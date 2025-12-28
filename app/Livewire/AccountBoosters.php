<?php

namespace App\Livewire;

use App\Models\Booster;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\CountrySetting;
use Livewire\Attributes\Layout;
use App\Http\Traits\PaymentTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;


class AccountBoosters extends Component
{
    use PaymentTrait, GeoLocationTrait;

    public $boosters = [];
    public $showModal = false;
    public $selectedBooster = null;
    public $selectedDuration = 30;
    public $selectedMultiplier = 1;
    public $totalAmount = 0;
    public $subtotal = 0;
    public $tax = 0;
    public $tax_rate = 0;
    public $countrySetting;
    public $activeSubscriptions = [];
    public $paymentMethod = 'gateway'; // 'wallet' or 'gateway'
    public $walletBalance = 0;
    public $isExtending = false;
    public $multipliers = [];
    public $durations = [];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->countrySetting = CountrySetting::where('country_id', $this->user->country_id)->first();
        $this->tax_rate = $this->countrySetting ? $this->countrySetting->tax_rate : 0;
        $this->walletBalance = $this->user->wallets()->where('currency', $this->user->currency)->first()->balance ?? 0;
        $this->boosters = Booster::where('is_active', 1)->get()->map(function($booster) {
            $price = $booster->prices()->where('country_id', $this->user->country->id)->first();
            $icon = 'bi-lightning-charge';
            switch ($booster->slug) {
                case 'task-limit-booster':
                    $icon = 'bi-briefcase';
                    break;
                case 'submission-speed-booster':
                    $icon = 'bi-speedometer2';
                    break;
                case 'feature-all-tasks':
                    $icon = 'bi-star';
                    break;
                case 'broadcast-all-tasks':
                    $icon = 'bi-broadcast';
                    break;
                case 'withdrawal-limit-booster':
                    $icon = 'bi-arrow-up-circle';
                    break;
                case 'referral-earnings-booster':
                    $icon = 'bi-people';
                    break;
                case 'premium-support':
                    $icon = 'bi-headset';
                    break;
                case 'task-analytics-plus':
                    $icon = 'bi-bar-chart';
                    break;
                case 'task-volume-booster':
                    $icon = 'bi-stack';
                    break;
            }
            $durationOptions = array_map(fn($i) => $booster->minimum_duration_days * $i, range(1, 10));
            return [
                'id' => $booster->id,
                'name' => $booster->name,
                'description' => $booster->description,
                'minimum_duration_days' => $booster->minimum_duration_days,
                'max_multiplier' => $booster->max_multiplier,
                'base_price' => $price ? $price->amount : 0,
                'icon' => $icon,
                'duration_options' => $durationOptions,
            ];
        });
        // Set default durations
        foreach ($this->boosters as $booster) {
            $this->durations[$booster['id']] = $booster['minimum_duration_days'];
        }
        $this->activeSubscriptions = $this->user->subscriptions()->where('expires_at', '>', now())->with('booster')->get();
    }

    public function updatedSelectedDuration()
    {
        $this->calculateTotal();
    }

    public function updatedSelectedMultiplier()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if(!$this->selectedDuration){
            $this->selectedDuration = 30;
        }

        if ($this->selectedBooster) {
            $this->subtotal = $this->selectedBooster['base_price'] * $this->selectedMultiplier * ($this->selectedDuration / 30);
            $this->tax = $this->subtotal * ($this->tax_rate / 100);
            $this->totalAmount = $this->subtotal + $this->tax;
        }
    }

    public function subscribe()
    {
        if (!$this->selectedBooster) {
            return;
        }

        $user = Auth::user();
        $this->calculateTotal();

        // 1. Create subscription record
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'booster_id' => $this->selectedBooster['id'],
            'cost' => $this->totalAmount,
            'currency' => $this->user->currency,
            'multiplier' => $this->selectedMultiplier,
            'duration_days' => $this->selectedDuration,
            'starts_at' => null, // To be set after payment
            'expires_at' => null, // To be set after payment
        ]);

        // 2. Create order
        $order = Order::create(['user_id' => $this->user->id]);

        // 3. Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'orderable_id' => $subscription->id,
            'orderable_type' => Subscription::class,
            'amount' => $this->totalAmount,
        ]);

        if ($this->paymentMethod === 'wallet') {
            // WALLET PAYMENT
            $wallet = $this->user->wallets()->where('currency', $this->user->currency)->first();
            if (!$wallet || $wallet->balance < $this->totalAmount) {
                session()->flash('error', 'Insufficient wallet balance.');
                return;
            }

            // 4. Create payment record
            $payment = Payment::create([
                'user_id' => $this->user->id,
                'order_id' => $order->id,
                'reference' => 'SUB-' . Str::random(10) . '-' . time(),
                'currency' => $this->user->currency,
                'amount' => $this->totalAmount,
                'vat_value' => $this->tax,
                'gateway' => 'wallet',
                'status' => 'success',
            ]);

            // 5. Deduct from wallet
            $wallet->balance -= $this->totalAmount;
            $wallet->save();

            // 6. Handle after-payment logic (same as PaymentController)
            // Check for an existing active subscription for the same booster
            $activeSubscription = $this->user->subscriptions()
                ->where('booster_id', $subscription->booster_id)
                ->where('id', '!=', $subscription->id)
                ->where('expires_at', '>', now())
                ->orderBy('expires_at', 'desc')
                ->first();

            if ($activeSubscription) {
                $subscription->starts_at = $activeSubscription->expires_at;
                $subscription->expires_at = $activeSubscription->expires_at->addDays($subscription->duration_days);
            } else {
                $subscription->starts_at = now();
                $subscription->expires_at = now()->addDays($subscription->duration_days);
            }
            $subscription->status = 'active';
            $subscription->save();
            return redirect()->back()->with('success', 'Subscription successful!');
        } else {
            // GATEWAY PAYMENT (existing logic)
            $payment = Payment::create([
                'user_id' => $this->user->id,
                'order_id' => $order->id,
                'reference' => 'SUB-' . Str::random(10) . '-' . time(),
                'currency' => $this->user->currency,
                'amount' => $this->totalAmount,
                'vat_value' => $this->tax,
                'gateway_id' => $this->countrySetting->gateway_id,
                'status' => 'pending',
            ]);

            $link = $this->initializePayment($payment);

            if($link){
                return redirect()->to($link);
            }else{
                return redirect()->back()->with('error', 'Failed to initiate payment. Please try again.');
            }
        }
    }

    public function extend($boosterId)
    {
        $booster = collect($this->boosters)->firstWhere('id', $boosterId);
        if ($booster) {
            $this->selectedBooster = $booster;
            $this->selectedMultiplier = 1; // Default, or could be from latest sub
            $this->selectedDuration = $booster['minimum_duration_days'];
            $this->isExtending = true;
            $this->showModal = true;
            $this->calculateTotal();
        }
    }

    public function updateMultiplier($id, $value)
    {
        $this->multipliers[$id] = (int)$value;
    }

    public function updateDuration($id, $value)
    {
        $this->durations[$id] = (int)$value;
    }

    public function getPrice($boosterId)
    {
        $multiplier = (int)($this->multipliers[$boosterId] ?? 1);
        $duration = (int)($this->durations[$boosterId] ?? 30);
        $booster = collect($this->boosters)->firstWhere('id', $boosterId);
        if ($booster) {
            return (float)$booster['base_price'] * ($duration / 30) * $multiplier;
        }
        return 0;
    }

    public function buyNow($boosterId)
    {
        $booster = collect($this->boosters)->firstWhere('id', $boosterId);
        if ($booster) {
            $this->selectedBooster = $booster;
            $this->selectedMultiplier = (int)($this->multipliers[$boosterId] ?? 1);
            $this->selectedDuration = (int)($this->durations[$boosterId] ?? $booster['minimum_duration_days']);
            $this->isExtending = false;
            $this->showModal = true;
            $this->calculateTotal();
        }
    }

    public function render()
    {
        return view('livewire.account-boosters');
    }
}
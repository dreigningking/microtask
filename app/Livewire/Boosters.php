<?php

namespace App\Livewire;

use App\Models\Booster;
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


class Boosters extends Component
{
    use PaymentTrait, GeoLocationTrait;
    
    public $boosters = [];
    public $selectedType = 'worker';
    public $filteredBoosters = [];
    public $showModal = false;
    public $selectedBooster = null;
    public $selectedDuration = 1;
    public $totalAmount = 0;
    public $subtotal = 0;
    public $tax = 0;
    public $tax_rate = 0;
    public $location;
    public $countrySetting;
    public $activeSubscriptionBoosterIds = [];
    public $paymentMethod = 'gateway'; // 'wallet' or 'gateway'
    public $walletBalance = 0;

    public function mount()
    {
       
    }

    public function getBoosterFeatures($booster)
    {
        $features = [];
        if ($booster->type === 'worker') {
            $features[] = $booster->active_tasks_per_hour . ' active tasks per hour';
            $features[] = 'Withdrawal limit multiplier: ' . $booster->withdrawal_maximum_multiplier;
        } else if ($booster->type === 'taskmaster') {
            if ($booster->featured_promotion) {
                $features[] = 'Featured job promotions';
            }
            if ($booster->broadcast_promotion) {
                $features[] = 'Broadcast badge on jobs';
            }
        }
        
        if (empty($features)) {
            $features[] = 'Standard features included.';
        }
        return $features;
    }

    public function switchType($type)
    {
        $this->selectedType = $type;
        $this->filterBoosters();
    }

    public function filterBoosters()
    {
        $this->filteredBoosters = collect($this->boosters)->where('type', $this->selectedType)->values()->all();
    }

    public function chooseBooster($slug)
    {
        $this->selectedBooster = collect($this->boosters)->firstWhere('slug', $slug);
        $this->selectedDuration = 1;
        $this->paymentMethod = 'gateway';
        $this->calculateTotal();
        $this->showModal = true;
    }

    public function updatedSelectedDuration()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if(!$this->selectedDuration){
            $this->selectedDuration = 1;
        }

        if ($this->selectedBooster) {
            $this->subtotal = $this->selectedBooster['monthly_price'] * $this->selectedDuration;
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
            'user_id' => $user->id,
            'booster_id' => $this->selectedBooster['id'],
            'cost' => $this->totalAmount,
            'currency' => $this->location->currency,
            'status' => 'pending', // Becomes active after payment
            'duration_months' => $this->selectedDuration,
            'starts_at' => null, // To be set after payment
            'expires_at' => null, // To be set after payment
            'features' => $this->selectedBooster['features'],
        ]);

        // 2. Create order
        $order = Order::create(['user_id' => $user->id]);

        // 3. Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'orderable_id' => $subscription->id,
            'orderable_type' => Subscription::class,
            'amount' => $this->totalAmount,
        ]);

        if ($this->paymentMethod === 'wallet') {
            // WALLET PAYMENT
            $wallet = $user->wallets()->where('currency', $this->location->currency)->first();
            if (!$wallet || $wallet->balance < $this->totalAmount) {
                session()->flash('error', 'Insufficient wallet balance.');
                return;
            }

            // 4. Create payment record
            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'reference' => 'SUB-' . Str::random(10) . '-' . time(),
                'currency' => $this->location->currency,
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
            $activeSubscription = $user->subscriptions()
                ->where('booster_id', $subscription->booster_id)
                ->where('id', '!=', $subscription->id)
                ->where('expires_at', '>', now())
                ->orderBy('expires_at', 'desc')
                ->first();

            if ($activeSubscription) {
                $subscription->starts_at = $activeSubscription->expires_at;
                $subscription->expires_at = $activeSubscription->expires_at->addMonths($subscription->duration_months);
            } else {
                $subscription->starts_at = now();
                $subscription->expires_at = now()->addMonths($subscription->duration_months);
            }
            $subscription->status = 'active';
            $subscription->save();

            session()->flash('success', 'Subscription successful!');

            return redirect()->route('subscriptions');
        } else {
            // GATEWAY PAYMENT (existing logic)
            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'reference' => 'SUB-' . Str::random(10) . '-' . time(),
                'currency' => $this->location->currency,
                'amount' => $this->totalAmount,
                'vat_value' => $this->tax,
                'gateway' => $this->countrySetting->gateway,
                'status' => 'pending',
            ]);

            $link = $this->initializePayment($payment);

            if($link){
                return redirect()->to($link);
            }else{
                session()->flash('error', 'Failed to initiate payment. Please try again.');
                return redirect()->back();
            }
        }
    }

    public function render()
    {
        return view('livewire.boosters');
    }
}
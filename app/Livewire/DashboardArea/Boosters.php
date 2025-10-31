<?php

namespace App\Livewire\DashboardArea;

use App\Models\Plan;
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
    
    public $plans = [];
    public $selectedType = 'worker';
    public $filteredPlans = [];
    public $showModal = false;
    public $selectedPlan = null;
    public $selectedDuration = 1;
    public $totalAmount = 0;
    public $subtotal = 0;
    public $tax = 0;
    public $tax_rate = 0;
    public $location;
    public $countrySetting;
    public $activeSubscriptionPlanIds = [];
    public $paymentMethod = 'gateway'; // 'wallet' or 'gateway'
    public $walletBalance = 0;

    public function mount()
    {
        $this->location = $this->getLocation();
        $this->countrySetting = CountrySetting::firstWhere('country_id', $this->location->country_id);
        $this->tax_rate = $this->countrySetting->tax_rate ?? 0;

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->activeSubscriptionPlanIds = $user->activeSubscriptions()->pluck('plan_id')->toArray();
        $this->walletBalance = $user->wallets()->where('currency', $this->location->currency)->first()->balance ?? 0;

        $this->plans = Plan::where('is_active', true)->get()->map(function ($plan) {
            $monthly_price = $plan->prices->firstWhere('country_id',$this->location->country_id)->amount;
            if ($monthly_price === null) {
                return null;
            }
            return [
                'id' => $plan->id,
                'slug' => $plan->slug,
                'name' => $plan->name,
                'description' => $plan->description,
                'type' => $plan->type,
                'monthly_price' => $monthly_price,
                'features' => $this->getPlanFeatures($plan),
            ];
        })->whereNotNull()->values()->all();
        
        $this->filterPlans();
    }

    public function getPlanFeatures($plan)
    {
        $features = [];
        if ($plan->type === 'worker') {
            $features[] = $plan->active_tasks_per_hour . ' active tasks per hour';
            $features[] = 'Withdrawal limit multiplier: ' . $plan->withdrawal_maximum_multiplier;
        } else if ($plan->type === 'taskmaster') {
            if ($plan->featured_promotion) {
                $features[] = 'Featured job promotions';
            }
            if ($plan->urgency_promotion) {
                $features[] = 'Urgent badge on jobs';
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
        $this->filterPlans();
    }

    public function filterPlans()
    {
        $this->filteredPlans = collect($this->plans)->where('type', $this->selectedType)->values()->all();
    }

    public function choosePlan($slug)
    {
        $this->selectedPlan = collect($this->plans)->firstWhere('slug', $slug);
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

        if ($this->selectedPlan) {
            $this->subtotal = $this->selectedPlan['monthly_price'] * $this->selectedDuration;
            $this->tax = $this->subtotal * ($this->tax_rate / 100);
            $this->totalAmount = $this->subtotal + $this->tax;
        }
    }

    public function subscribe()
    {
        if (!$this->selectedPlan) {
            return;
        }

        $user = Auth::user();
        $this->calculateTotal();

        // 1. Create subscription record
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $this->selectedPlan['id'],
            'cost' => $this->totalAmount,
            'currency' => $this->location->currency,
            'status' => 'pending', // Becomes active after payment
            'duration_months' => $this->selectedDuration,
            'starts_at' => null, // To be set after payment
            'expires_at' => null, // To be set after payment
            'features' => $this->selectedPlan['features'],
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
            // Check for an existing active subscription for the same plan
            $activeSubscription = $user->subscriptions()
                ->where('plan_id', $subscription->plan_id)
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
        return view('livewire.dashboard-area.boosters');
    }
}
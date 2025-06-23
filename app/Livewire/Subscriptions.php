<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\CountrySetting;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PaymentTrait;
use App\Http\Traits\GeoLocationTrait;

class Subscriptions extends Component
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

    public function mount()
    {
        $this->location = $this->getLocation();
        $this->countrySetting = CountrySetting::firstWhere('country_id', $this->location->country_id);
        $this->tax_rate = $this->countrySetting->tax_rate ?? 0;

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->activeSubscriptionPlanIds = $user->activeSubscriptions()->pluck('plan_id')->toArray();

        $this->plans = Plan::where('is_active', true)->get()->map(function ($plan) {
            $monthly_price = $plan->getCountryPrice($this->location->country_id);
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
        $this->calculateTotal();
        $this->showModal = true;
    }

    public function updatedSelectedDuration()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
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

        /** @var \App\Models\User $user */
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

        // 4. Create payment record
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

        // 5. Initialize payment
        $link = $this->initializePayment($payment);

        if($link){
            // Redirect to payment gateway
            return redirect()->to($link);
        }else{
            session()->flash('error', 'Failed to initiate payment. Please try again.');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.subscriptions');
    }
} 
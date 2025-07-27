<?php

namespace App\Livewire\DashboardArea\Jobs;

use App\Models\Task;
use App\Models\Order;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Location;
use App\Models\Platform;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\TaskTemplate;
use App\Models\TaskPromotion;
use Livewire\WithFileUploads;
use App\Models\CountrySetting;
use Livewire\Attributes\Layout;
use App\Http\Traits\PaymentTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;
use App\Livewire\DashboardArea\Jobs\TemplateFields;


class PostJob extends Component
{
    use WithFileUploads,GeoLocationTrait,PaymentTrait;

    // Step tracking
    public $isLoggedIn = false;
    public $currentStep = 1;
    public $totalSteps = 4;
    
    // Data collections
    public $platforms;
    public $templates;
    public $location;
    public $countries;
    public $countrySetting;
    
    // Template data from child component
    public $templateData = [];
    
    // Step 1: Job Details
    // Basic Information
    public $title;
    public $platform_id;
    public $template_id;
    public $expected_completion_minutes;
    public $time_unit = 'minutes';
    
    // Job Description
    public $description;
    public $requirements = [];
    public $visibility = 'public';
    public $expiry_date;

    // Monitoring Preferences
    public $monitoring_type = 'self_monitoring';
    
    // Budget & Capacity
    public $budget_per_person = 1;
    public $expected_budget = 0;
    public $currency;
    public $currency_symbol;
    public $basePrice = 0;
    public $serviceFee = 0;
    public $tax_rate = 0;
    public $restricted_countries = [];

    // Transaction charges
    public $transactionPercentage = 0;
    public $transactionFixed = 0;
    public $transactionCap = 0;

    // Promotions
    public $featuredPrice = 0;
    public $featured_amount = 0;
    public $urgentPrice = 0;
    public $urgent_amount = 0;
    public $featured = false;
    public $urgent = false;
    public $featured_days = 1;


    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;
    public $number_of_people = 1;
    
    // Terms & Conditions
    public $terms = false;
    public $email;
    public $password;
    public $remember = false;
    
    // Define listeners for model changes
    protected $listeners = [
        'updateSelect2' => 'handleSelect2Update',
        'templateFieldsLoaded' => 'handleTemplateFieldsLoaded',
        'templateFieldUpdated' => 'handleTemplateFieldUpdated'
    ];
    
    // Validation rules
    protected $rules = [
        'title' => 'required|min:5',
        'platform_id' => 'required',
        'expected_completion_minutes' => 'required|numeric|min:1',
        'description' => 'required|min:20',
        'requirements' => 'nullable|array',
        'budget_per_person' => 'required|numeric|min:0',
        'number_of_people' => 'required|numeric|min:1',
        'monitoring_type' => 'required',
        'visibility' => 'required|in:public,private',
        'expiry_date' => 'nullable|date|after:today',
        'email' => 'required|email|sometimes',
        'password' => 'required|sometimes',
        'terms' => 'accepted|sometimes',
    ];

    // Validation messages
    protected $messages = [
        'title.required' => 'Please enter a job title',
        'platform_id.required' => 'Please select a platform',
        'description.required' => 'Please provide a job description',
        'requirements.required' => 'Please enter at least one required skill',
        'budget_per_person.required' => 'Please enter a budget per person',
    ];

    public $min_budget_per_person = 0;
    public $monitoring_fee = 0;
    public $enable_system_monitoring = false;
    public $showSelfMonitoringRefundNote = false;

    public $serviceUnavailable = false;
    public $unavailableCountryName = null;

    public static $allowedFileTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    public $canSaveDraft = false;

    public function getStepRules()
    {
        $rules = [];
        if ($this->currentStep == 1) {
            // Step 1: Template selection (must select a template only)
            $rules = [
                'template_id' => 'required',
            ];
        } elseif ($this->currentStep == 2) {
            // Step 2: Job details
            $rules = [
                'title' => 'required|min:5',
                'description' => 'required|min:20',
                'expected_completion_minutes' => 'required|numeric|min:1',
                'requirements' => 'nullable|array',
            ];
            // Add validation rules for required template fields
            if (!empty($this->templateData)) {
                foreach ($this->templateData as $key => $field) {
                    if ($field['required'] ?? false) {
                        $rules["templateData.{$key}.value"] = 'required';
                        $this->messages["templateData.{$key}.value.required"] = "The {$field['title']} field is required";
                    }
                }
            }
        } elseif ($this->currentStep == 3) {
            // Step 3: Budget, expiry, monitoring, etc.
            $rules = [
                'expiry_date' => 'nullable|date|after:today',
                'budget_per_person' => 'required|numeric|min:' . $this->min_budget_per_person,
                'number_of_people' => 'required|numeric|min:1',
                'monitoring_type' => 'required',
                'visibility' => 'required|in:public,private',
            ];
        } elseif ($this->currentStep == 4) {
            // Step 4: Login or review/confirmation
            if (!Auth::check()) {
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required',
                ];
            } else {
                $rules = [
                    'terms' => 'accepted',
                ];
            }
        }
        return $rules;
    }

    public function mount()
    {
        $this->isLoggedIn = Auth::check();
        $this->location = $this->getLocation();
        $this->currency = $this->location->currency;
        $this->currency_symbol = $this->location->currency_symbol;
        $this->requirements = [];
        $this->platforms = Platform::where('is_active', true)->get();
        $this->templates = TaskTemplate::where('is_active', true)
            ->whereHas('prices', function($q) {
                $q->where('country_id', $this->location->country_id);
            })->get();
        // Determine approved countries using Country model methods
        $allCountries = Country::orderBy('name')->get();
        $approvedCountries = collect();
        foreach ($allCountries as $country) {
            if ($country->status) {
                $approvedCountries->push($country);
            }
        }
        $this->countries = $approvedCountries;
        // Set countrySetting for the user's/guest's country if available
        $this->countrySetting = $this->location->country_id ? $approvedCountries->firstWhere('id', $this->location->country_id)?->setting : null;
        // If user's/guest's country is not approved, set serviceUnavailable
        if (!$approvedCountries->pluck('id')->contains($this->location->country_id)) {
            $this->serviceUnavailable = true;
            $this->unavailableCountryName = $this->location->country_name ?? 'your country';
        }

        // Set pricing and other settings if available
        $this->featured = $this->hasFeaturedInSubscription();
        $this->urgent = $this->hasUrgentInSubscription();
        $this->featuredPrice = $this->hasFeaturedInSubscription() ? 0 : ($this->countrySetting->feature_rate ?? 0);
        $this->urgentPrice = $this->hasUrgentInSubscription() ? 0 : ($this->countrySetting->urgent_rate ?? 0);
        $this->tax_rate = $this->countrySetting->tax_rate ?? 0;
        if ($this->countrySetting && $this->countrySetting->transaction_charges) {
            $transactionCharges = $this->countrySetting->transaction_charges;
            $this->transactionPercentage = $transactionCharges['percentage'] ?? 0;
            $this->transactionFixed = $transactionCharges['fixed'] ?? 0;
            $this->transactionCap = $transactionCharges['cap'] ?? 0;
        }
        $this->min_budget_per_person = 0;
        if ($this->template_id) {
            $template = TaskTemplate::find($this->template_id);
            if ($template) {
                $this->min_budget_per_person = $template->prices->firstWhere('country_id',$this->location->country_id)->amount;
            }
        }
        // Set budget_per_person and expected_budget to minimum on first visit
        if (!$this->budget_per_person || $this->budget_per_person < $this->min_budget_per_person) {
            $this->budget_per_person = $this->min_budget_per_person;
        }
        $this->expected_budget = $this->budget_per_person * 1;
        $this->enable_system_monitoring = (bool) Setting::getValue('enable_system_monitoring', false);
        $this->updateMonitoringFee();
        $this->updateTotals();
    }
    
    public function nextStep()
    {
        try {
            $this->validate($this->getStepRules());
            if ($this->currentStep < $this->totalSteps) {
                $this->currentStep++;
                if($this->currentStep == 2){
                    $this->dispatch('step2-shown');
                }
            } elseif ($this->currentStep == $this->totalSteps) {
                // On step 4, if not logged in, handle login
                if (!Auth::check()) {
                    $this->login();
                    // If login successful, stay on step 4 and show review/confirmation
                    if (Auth::check()) {
                        $this->isLoggedIn = true;
                        // No increment, stay on step 4
                    }
                } else {
                    $this->submitJob();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationErrors', $e->validator->errors()->toArray());
            throw $e;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            if($this->currentStep == 2){
                $this->dispatch('step2-shown');
            }
        }
    }
    
    public function handleSelect2Update($data, $element)
    {
        if($element == 'restricted_countries'){
            $this->restricted_countries = $data;
        }elseif($element == 'requirements'){
            $this->requirements = $data;
        }
    }
    
    /**
     * Handle template fields loaded event from child component
     */
    public function handleTemplateFieldsLoaded($templateFieldValues)
    {
        // Always set the full array, not just those with values
        $this->templateData = $templateFieldValues;
    }
    
    /**
     * Handle template field updated event from child component
     */
    public function handleTemplateFieldUpdated($key, $value, $allValues)
    {
        $this->templateData = $allValues;
    }

    public function updateTotals()
    {
        $this->featuredPrice = $this->hasFeaturedInSubscription() ? 0 : ($this->countrySetting->feature_rate ?? 0);
        $this->urgentPrice = $this->hasUrgentInSubscription() ? 0 : ($this->countrySetting->urgent_rate ?? 0);
        $this->expected_budget = ($this->budget_per_person ?? 0) * $this->number_of_people;
        $baseAmount = $this->expected_budget;
        $this->featured_amount = $this->featured ? ($this->featuredPrice * $this->featured_days) : 0;
        $baseAmount += $this->featured_amount;
        $this->urgent_amount = $this->urgent ? ($this->urgentPrice * $this->number_of_people) : 0;
        $baseAmount += $this->urgent_amount;
        $this->monitoring_fee = 0;
        $people = ($this->number_of_people && $this->number_of_people > 0) ? $this->number_of_people : 1;
        $this->showSelfMonitoringRefundNote = false;
        if ($this->monitoring_type === 'admin_monitoring') {
            $this->monitoring_fee = ($this->countrySetting->admin_monitoring_cost ?? 0) * $people;
        } elseif ($this->monitoring_type === 'system_monitoring') {
            $this->monitoring_fee = ($this->countrySetting->system_monitoring_cost ?? 0) * $people;
        } elseif ($this->monitoring_type === 'self_monitoring') {
            $this->monitoring_fee = ($this->countrySetting->admin_monitoring_cost ?? 0) * $people;
            $this->showSelfMonitoringRefundNote = true;
        }
        $baseAmount += $this->monitoring_fee;
        $this->serviceFee = $this->calculateServiceFee($baseAmount);
        $this->subtotal = $baseAmount + $this->serviceFee;
        $this->tax = $this->subtotal * ($this->tax_rate / 100);
        $this->total = $this->subtotal + $this->tax;
    }

    // Calculate service fee based on transaction charges
    public function calculateServiceFee($baseAmount)
    {
        
        $percentageFee = $baseAmount * ($this->transactionPercentage / 100);
        $calculatedFee = $percentageFee + $this->transactionFixed;
        
        // Apply cap if needed
        if ($this->transactionCap > 0 && $calculatedFee > $this->transactionCap) {
            $this->serviceFee = $this->transactionCap;
        } else {
            $this->serviceFee = $calculatedFee;
        }

        return $this->serviceFee;
    }
    
    public function addSkill($skill)
    {
        if (!empty($skill) && !in_array($skill, $this->requirements)) {
            $this->requirements[] = $skill;
        }
    }
    
    public function removeSkill($index)
    {
        if (isset($this->requirements[$index])) {
            unset($this->requirements[$index]);
            $this->requirements = array_values($this->requirements);
        }
    }
    
    public function increasePeople()
    {
        $this->number_of_people++;
        $this->updateTotals();
    }
    
    public function decreasePeople()
    {
        if ($this->number_of_people > 1) {
            $this->number_of_people--;
            $this->updateTotals();
        }
    }
    
    
    public function convertTimeToMinutes()
    {
        $minutes = $this->expected_completion_minutes;
        
        switch ($this->time_unit) {
            case 'hours':
                $minutes *= 60;
                break;
            case 'days':
                $minutes *= 1440; // 24 hours * 60 minutes
                break;
            case 'weeks':
                $minutes *= 10080; // 7 days * 24 hours * 60 minutes
                break;
            default: $minutes *= 1;
        }
        
        return $minutes;
    }
    
    public function applyCoupon()
    {
        // Logic to apply coupon code would go here
        // This would typically involve API calls to validate the coupon
        
        $this->dispatch('coupon-applied', [
            'success' => true,
            'message' => 'Coupon applied successfully!'
        ]);
    }
    
    public function saveAsDraft()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to save a draft.');
            return;
        }
        // Only require template_id and platform_id (from template)
        if (!$this->template_id) {
            $this->addError('template_id', 'Please select a template.');
            return;
        }
        $template = TaskTemplate::find($this->template_id);
        if (!$template) {
            $this->addError('template_id', 'Invalid template selected.');
            return;
        }
        $platform_id = $template->platform_id;
        $task = new Task();
        $task->user_id = Auth::id();
        $task->template_id = $this->template_id;
        $task->platform_id = $platform_id;
        $task->title = $this->title;
        $task->description = $this->description;
        $task->expected_completion_minutes = $this->expected_completion_minutes;
        $task->expected_budget = $this->expected_budget;
        $task->requirements = $this->requirements;
        $task->number_of_people = $this->number_of_people;
        $task->visibility = $this->visibility;
        $task->budget_per_person = $this->budget_per_person;
        $task->currency = $this->currency;
        $task->expiry_date = $this->expiry_date;
        $task->monitoring_type = $this->monitoring_type;
        $task->restricted_countries = $this->restricted_countries;
        $task->is_active = false; // Mark as draft
        if (!empty($this->templateData)) {
            $task->template_data = $this->templateData;
        }
        $task->save();
        // Save promotions if selected
        if ($this->featured) {
            $promotion = $this->createPromotion($task->id, 'featured');
        }
        if ($this->urgent) {
            $promotion = $this->createPromotion($task->id, 'urgent');
        }
        return redirect()->route('jobs.index');
    }
    
    public function submitJob()
    {
        $this->validate($this->getStepRules());
        
        // If user is not logged in, we don't proceed with job submission
        if (!Auth::check()) {
            // Just validate login fields - actual login is handled by the login method
            return;
        }
        
        // Convert time units to minutes
        $minutes = $this->convertTimeToMinutes();
        
        // Calculate total budget based on per person budget
        $this->updateTotals();
        
        // Create the task
        $task = new Task();
        $task->user_id = Auth::id();
        $task->template_id = $this->template_id ?? 1; // Default template if none selected
        $task->platform_id = TaskTemplate::find($this->platform_id)->platform_id;
        $task->title = $this->title;
        $task->description = $this->description;
        $task->expected_completion_minutes = $minutes;
        $task->expected_budget = $this->expected_budget;
        $task->requirements = $this->requirements;
        $task->number_of_people = $this->number_of_people;
        $task->visibility = $this->visibility;
        $task->budget_per_person = $this->budget_per_person;
        $task->currency = $this->currency;
        $task->expiry_date = $this->expiry_date;
        
        // Store template field values if any
        if (!empty($this->templateData)) {
            $task->template_data = $this->templateData;
        }
        
        // Convert monitoring frequency to match the database enum values
        $task->monitoring_type = $this->monitoring_type;
        
        $task->restricted_countries = $this->restricted_countries;
        $task->is_active = true;
        $task->save();
        
        $order = Order::create(['user_id' => Auth::id()]);
        OrderItem::create([
            'order_id' => $order->id,
            'orderable_id' => $task->id,
            'orderable_type' => get_class($task),
            'amount' => $this->total - ($this->featured_amount + $this->urgent_amount),
        ]);
        // If promotions are selected, create them
        if ($this->featured) {
            $promotion = $this->createPromotion($task->id, 'featured');
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $promotion->id,
                'orderable_type' => get_class($promotion),
                'amount' => $this->featured_amount,
            ]);
        }
        
        if ($this->urgent) {
            $promotion = $this->createPromotion($task->id, 'urgent');
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $promotion->id,
                'orderable_type' => get_class($promotion),
                'amount' => $this->urgent_amount,
            ]);
        }
        
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'reference' => 'SUB-' . Str::random(10) . '-' . time(),
            'currency' => $this->currency,
            'amount' => $this->total,
            'vat_value' => $this->tax,
            'gateway' => $this->countrySetting->gateway,
            'status' => 'pending',
        ]);
        $link = $this->initializePayment($payment);
        if($link){
            // Redirect to payment gateway
            return redirect()->to($link);
        }else{
            return redirect()->back()->with('error', 'Failed to initiate payment. Please try again.');
        }
    }
    
    protected function createPromotion($taskId, $type)
    {
        return TaskPromotion::create([
            'user_id'=> Auth::id(),
            'type'=> $type,
            'task_id'=> $taskId,
            'days'=> $type === 'featured' ? $this->featured_days : 1,
            'cost'=> $type === 'featured' ? $this->featuredPrice * $this->featured_days : $this->urgentPrice * $this->number_of_people,
            'currency'=> $this->currency
        ]);
    }

    /**
     * Handle user login
     */
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $this->remember ?? false;
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $remember)) {
            $this->reset(['password']);
            $this->isLoggedIn = true;
            $this->dispatch('UserHasLoggedIn');
        } else {
            session()->flash('error', 'Invalid credentials. Please try again.');
            $this->addError('email', 'These credentials do not match our records.');
        }
    }

    public function updatedMonitoringType($value)
    {
        $this->updateTotals();
    }

    public function updateMonitoringFee()
    {
        $this->monitoring_fee = 0;
        if ($this->monitoring_type === 'admin_monitoring') {
            $this->monitoring_fee = $this->countrySetting->admin_monitoring_cost ?? 0;
        } elseif ($this->monitoring_type === 'system_monitoring') {
            $this->monitoring_fee = $this->countrySetting->system_monitoring_cost ?? 0;
        }
    }

    public function getMonitoringLabelProperty()
    {
        if ($this->monitoring_type === 'admin_monitoring') {
            return 'Admin-Monitored (' . $this->currency_symbol . number_format($this->countrySetting->admin_monitoring_cost ?? 0, 2) . ')';
        } elseif ($this->monitoring_type === 'system_monitoring') {
            return 'System-Automated (' . $this->currency_symbol . number_format($this->countrySetting->system_monitoring_cost ?? 0, 2) . ')';
        }
        return 'Self-Monitored (Free)';
    }

    public function updatedBudgetPerPerson($value)
    {
        if ($value === '' || !is_numeric($value) || $value < $this->min_budget_per_person) {
            $this->budget_per_person = $this->min_budget_per_person;
        }
        $this->updateTotals();
    }

    public function updatedNumberOfPeople($value)
    {
        if ($value === '' || !is_numeric($value) || $value < 1) {
            $this->number_of_people = 1;
        }
        $this->updateTotals();
    }

    public function updatedFeaturedDays($value)
    {
        if ($value === '' || !is_numeric($value) || $value < 1) {
            $this->featured_days = 1;
        }
        $this->updateTotals();
    }

    public function render()
    {
        return view('livewire.dashboard-area.jobs.post-job');
    }

    public function selectTemplate($templateId)
    {
        $this->template_id = $templateId;
        $template = TaskTemplate::find($templateId);
        if ($template) {
            //$this->platform_id = $template->platform_id; // Set platform_id from template
            $this->description = $template->description ?? $this->description;
            $this->min_budget_per_person = $template->prices->firstWhere('country_id',$this->location->country_id)->amount;
            if ($this->budget_per_person < $this->min_budget_per_person) {
                $this->budget_per_person = $this->min_budget_per_person;
            }
            $this->updateTotals();
        }
        \Log::info('dispatching event with template_id: ' . $this->template_id);
        $this->dispatch('templateSelected', templateId:$this->template_id);
    }

    public function hasFeaturedInSubscription()
    {
        if (!Auth::check()) return false;
        $subs = Auth::user()->activeSubscriptions()->get();
        foreach ($subs as $sub) {
            if (in_array('featured', $sub->features ?? [])) {
                return true;
            }
        }
        return false;
    }

    public function hasUrgentInSubscription()
    {
        if (!Auth::check()) return false;
        $subs = Auth::user()->activeSubscriptions()->get();
        foreach ($subs as $sub) {
            if (in_array('urgent', $sub->features ?? [])) {
                return true;
            }
        }
        return false;
    }
}

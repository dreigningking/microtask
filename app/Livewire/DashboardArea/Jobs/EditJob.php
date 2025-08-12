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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;


class EditJob extends Component
{
    use WithFileUploads, GeoLocationTrait, PaymentTrait;

    // Task instance
    public Task $task;
    
    // Data collections
    public $platforms;
    public $templates;
    public $location;
    public $countries;
    public $countrySetting;
    
    // Template data from child component
    public $templateData = [];
    
    // Basic Information
    public $title;
    public $platform_id;
    public $template_id;
    public $expected_completion_minutes;
    public $time_unit = 'minutes';
    
    // Job Description
    public $description;
    public $files = [];
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
    public $allow_multiple_submissions = false; // New field for allowing multiple submissions from single user

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
    
    // Define listeners for model changes
    protected $listeners = [
        'updateSelect2' => 'handleSelect2Update',
        'templateFieldsLoaded' => 'handleTemplateFieldsLoaded',
        'templateFieldUpdated' => 'handleTemplateFieldUpdated'
    ];
    
    // Validation rules
    protected $rules = [
        'title' => 'required|min:5',
        'expected_completion_minutes' => 'required|numeric|min:1',
        'description' => 'required|min:20',
        'requirements' => 'nullable|array',
        'budget_per_person' => 'required|numeric|min:0',
        'number_of_people' => 'required|numeric|min:1',
        'monitoring_type' => 'required',
        'visibility' => 'required|in:public,private',
        'expiry_date' => 'nullable|date|after:today',
        'allow_multiple_submissions' => 'boolean',
        'terms' => 'accepted',
        'files.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png', // 10MB max, allowed types
    ];

    // Validation messages
    protected $messages = [
        'title.required' => 'Please enter a job title',
        'description.required' => 'Please provide a job description',
        'requirements.required' => 'Please enter at least one required skill',
        'budget_per_person.required' => 'Please enter a budget per person',
        'files.*.max' => 'Each file must not exceed 10MB.',
        'files.*.mimes' => 'Only PDF, DOC, JPG, and PNG files are allowed.',
    ];

    public $min_budget_per_person = 0;
    public $monitoring_fee = 0;
    public $enable_system_monitoring = false;
    public $showSelfMonitoringRefundNote = false;

    public $serviceUnavailable = false;
    public $unavailableCountryName = null;

    public static $allowedFileTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    public $isPaid = false;
    public $hasWorkers = false;
    public $canEditAll = false;
    public $canEditSome = false;
    public $canEditNone = false;
    public $canEdit = false; // New property to track if job can be edited

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->location = $this->getLocation();
        $this->currency = $this->location->currency;
        $this->currency_symbol = $this->location->currency_symbol;
        
        // Load task data into component properties
        $this->loadTaskData();
        
        // Load collections
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
        $this->featuredPrice = $this->hasFeaturedInSubscription() ? 0 : ($this->countrySetting->feature_rate ?? 0);
        $this->urgentPrice = $this->hasUrgentInSubscription() ? 0 : ($this->countrySetting->urgent_rate ?? 0);
        $this->tax_rate = $this->countrySetting->tax_rate ?? 0;
        if ($this->countrySetting && $this->countrySetting->transaction_charges) {
            $transactionCharges = $this->countrySetting->transaction_charges;
            $this->transactionPercentage = $transactionCharges['percentage'] ?? 0;
            $this->transactionFixed = $transactionCharges['fixed'] ?? 0;
            $this->transactionCap = $transactionCharges['cap'] ?? 0;
        }
        
        // Set minimum budget per person
        if ($this->template_id) {
            $template = TaskTemplate::find($this->template_id);
            if ($template) {
                $this->min_budget_per_person = $template->prices->firstWhere('country_id', $this->location->country_id)->amount;
            }
        }
        
        $this->enable_system_monitoring = (bool) Setting::getValue('enable_system_monitoring', false);
        $this->updateMonitoringFee();
        $this->updateTotals();

        // Check payment and worker status
        $this->checkEditPermissions();
    }

    private function loadTaskData()
    {
        // Load basic information
        $this->title = $this->task->title;
        $this->platform_id = $this->task->platform_id;
        $this->template_id = $this->task->template_id;
        $this->description = $this->task->description;
        $this->expected_completion_minutes = $this->task->expected_completion_minutes;
        $this->budget_per_person = $this->task->budget_per_person;
        $this->number_of_people = $this->task->number_of_people;
        $this->visibility = $this->task->visibility;
        $this->expiry_date = $this->task->expiry_date ? $this->task->expiry_date->format('Y-m-d') : null;
        $this->monitoring_type = $this->task->monitoring_type;
        $this->restricted_countries = $this->task->restricted_countries ?? [];
        $this->requirements = $this->task->requirements ?? [];
        $this->files = $this->task->files ?? [];
        $this->templateData = $this->task->template_data ?? [];
        $this->allow_multiple_submissions = $this->task->allow_multiple_submissions ?? false;

        // Load existing promotions
        $this->loadExistingPromotions();
    }

    private function loadExistingPromotions()
    {
        $existingPromotions = $this->task->promotions;
        
        foreach ($existingPromotions as $promotion) {
            if ($promotion->type === 'featured') {
                $this->featured = true;
                $this->featured_days = $promotion->days;
            } elseif ($promotion->type === 'urgent') {
                $this->urgent = true;
            }
        }
    }

    private function checkEditPermissions()
    {
        // Check if task has been paid for
        $orderItem = $this->task->orderItem;
        $order = $orderItem ? $orderItem->order : null;
        $payment = $order ? $order->payment : null;
        $this->isPaid = $payment && $payment->status === 'success';
        
        // Check if task has workers
        $this->hasWorkers = $this->task->workers()->count() > 0;

        // Determine edit permissions - jobs can only be edited if not paid for
        if (!$this->isPaid) {
            $this->canEditAll = true;
            $this->canEdit = true; // Job is editable
        } else {
            // Job has been paid for, cannot be edited
            $this->canEditNone = true;
            $this->canEdit = false; // Job is not editable
        }
    }
    
    // Add file removal method
    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files);
        }
    }

    public function updatedFiles()
    {
        $this->validateOnly('files.*');
        $processedFiles = [];

        foreach ($this->files as $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $path = $file->store('task-files', 'public');
                $processedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'storage/' . $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ];
            } elseif (is_array($file) && isset($file['name'])) {
                // Already processed file info, keep it
                $processedFiles[] = $file;
            }
        }

        $this->files = $processedFiles;
    }
    
    public function handleSelect2Update($data, $element)
    {
        if($element == 'restricted_countries'){
            $this->restricted_countries = $data;
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
    
    public function submitJob()
    {
        // Check if job can be edited
        if (!$this->canEdit) {
            session()->flash('error', 'This job has been paid for and cannot be modified.');
            return;
        }
        
        $this->validate();
        
        // Convert time units to minutes
        $minutes = $this->convertTimeToMinutes();
        
        // Calculate total budget based on per person budget
        $this->updateTotals();
        
        // Update the existing task
        $this->task->title = $this->title;
        $this->task->description = $this->description;
        $this->task->expected_completion_minutes = $minutes;
        $this->task->expected_budget = $this->expected_budget;
        $this->task->files = $this->files;
        $this->task->requirements = $this->requirements;
        $this->task->number_of_people = $this->number_of_people;
        $this->task->visibility = $this->visibility;
        $this->task->budget_per_person = $this->budget_per_person;
        $this->task->currency = $this->currency;
        $this->task->expiry_date = $this->expiry_date;
        $this->task->monitoring_type = $this->monitoring_type;
        $this->task->restricted_countries = $this->restricted_countries;
        $this->task->is_active = true;
        $this->task->allow_multiple_submissions = $this->allow_multiple_submissions;
        
        // Store template field values if any
        if (!empty($this->templateData)) {
            $this->task->template_data = $this->templateData;
        }
        
        $this->task->save();
        
        // Handle promotions - only create new ones if they don't exist
        $this->handlePromotions();
        
        session()->flash('success', 'Job updated successfully! Redirecting to payment...');
        
        // Create order and payment
        $order = Order::create(['user_id' => Auth::id()]);
        OrderItem::create([
            'order_id' => $order->id,
            'orderable_id' => $this->task->id,
            'orderable_type' => get_class($this->task),
            'amount' => $this->total - ($this->featured_amount + $this->urgent_amount),
        ]);
        
        // Create order items for promotions if they exist
        $this->createPromotionOrderItems($order);
        
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

    private function handlePromotions()
    {
        // Delete existing promotions
        $this->task->promotions()->delete();
        
        // Create new promotions if selected
        if ($this->featured) {
            $this->createPromotion($this->task->id, 'featured');
        }
        if ($this->urgent) {
            $this->createPromotion($this->task->id, 'urgent');
        }
    }

    private function createPromotionOrderItems($order)
    {
        if ($this->featured) {
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $this->task->promotions()->where('type', 'featured')->first()->id,
                'orderable_type' => TaskPromotion::class,
                'amount' => $this->featured_amount,
            ]);
        }
        
        if ($this->urgent) {
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $this->task->promotions()->where('type', 'urgent')->first()->id,
                'orderable_type' => TaskPromotion::class,
                'amount' => $this->urgent_amount,
            ]);
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

    public function hasFeaturedInSubscription()
    {
        if (!Auth::check()) return false;
        // For now, return false - this can be implemented later when subscription system is ready
        return false;
    }

    public function hasUrgentInSubscription()
    {
        if (!Auth::check()) return false;
        // For now, return false - this can be implemented later when subscription system is ready
        return false;
    }

    public function render()
    {
        return view('livewire.dashboard-area.jobs.edit-job');
    }
}


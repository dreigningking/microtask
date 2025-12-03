<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Order;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Platform;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\PlatformTemplate;
use App\Models\TaskPromotion;
use Livewire\WithFileUploads;
use App\Http\Traits\PaymentTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TaskCreate extends Component
{
    use WithFileUploads,PaymentTrait;

    // Step tracking
    public $currentStep = 1;
    public $totalSteps = 4;

    // Template loading state
    public $isTemplateLoading = false;
    public $templateFieldsLoaded = false;
    
    // Data collections
    public $platforms;
    public $templates;
    public $countries;
    public $countrySetting;
    public $restriction = 'all';
    
    // Template data from child component
    public $templateData = [];
    
    // Step 1: Job Details
    // Basic Information
    public $title;
    public $platform_id;
    public $template_id;
    public $average_completion_minutes;
    public $time_unit = 'minutes';
    
    // Job Description
    public $description;
    public $requirements = [];
    public $visibility = 'public';
    public $expiry_date;

    // Review Preferences
    public $review_type = 'self_review';
    
    // Budget & Capacity
    public $budget_per_submission = 1;
    public $expected_budget = 0;
    public $currency;
    public $currency_symbol;
    public $basePrice = 0;
    public $serviceFee = 0;
    public $tax_rate = 0;
    public $task_countries = [];
    public $allow_multiple_submissions = false; // New field for allowing multiple submissions from single user

    // Transaction charges
    public $transactionPercentage = 0;
    public $transactionFixed = 0;
    public $transactionCap = 0;

    // Promotions
    public $featuredPrice = 0;
    public $featured_amount = 0;
    public $broadcastPrice = 0;
    public $broadcast_amount = 0;
    public $featured = false;
    public $broadcast = false;
    public $featured_days = 1;


    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;
    public $number_of_submissions = 1;
    
    // Terms & Conditions
    public $terms = false;
    
    // Define listeners for model changes
    protected $listeners = [
        'templateFieldsAreLoaded' => 'handleTemplateFieldsLoaded',
        'templateFieldUpdated' => 'handleTemplateFieldUpdated',
        'choiceSelected' => 'handleChoiceSelected'
    ];
    
    // Validation rules
    protected $rules = [
        'title' => 'required|min:5',
        'platform_id' => 'required',
        'average_completion_minutes' => 'required|numeric|min:1',
        'description' => 'required|min:20',
        'requirements' => 'nullable|array',
        'budget_per_submission' => 'required|numeric|min:0',
        'number_of_submissions' => 'required|numeric|min:1',
        'review_type' => 'required',
        'visibility' => 'required|in:public,private',
        'expiry_date' => 'nullable|date|after:today',
        'terms' => 'accepted',
    ];

    // Validation messages
    protected $messages = [
        'title.required' => 'Please enter a job title',
        'platform_id.required' => 'Please select a platform',
        'description.required' => 'Please provide a job description',
        'requirements.required' => 'Please enter at least one required skill',
        'budget_per_submission.required' => 'Please enter a budget per person',
    ];

    public $min_budget_per_submission = 0;
    public $review_fee = 0;
    public $enable_system_submission_review = false;
    public $showSystemReviewRefundNote = false;
    public $adminReviewCost = 0;
    public $systemReviewCost = 0;
    public $hasFeaturedSubscription = false;
    public $hasBroadcastSubscription = false;
    public $featuredSubscriptionDaysRemaining = 0;

   

    public static $allowedFileTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    public function getStepRules()
    {
        $rules = [];
        if ($this->currentStep == 1) {
            // Step 1: Template selection and basic info
            $rules = [
                'title' => 'required|min:5',
                'description' => 'required|min:20',
                'template_id' => 'required',
            ];

            // Add validation rules for required template fields in step 1
            if (!empty($this->templateData)) {
                Log::info("Template data for step 1 validation:", $this->templateData);
                foreach ($this->templateData as $key => $field) {
                    if ($field['required'] ?? false) {
                        // For file fields, check if a file path exists
                        if (isset($field['type']) && $field['type'] === 'file') {
                            // Don't add validation rule for file fields, we'll check manually
                            Log::info("File field detected in step 1: {$key}", [
                                'field_type' => $field['type'],
                                'field_value' => $field['value'],
                                'is_empty' => empty($field['value']),
                                'field_structure' => $field
                            ]);
                        } else {
                            $rules["templateData.{$key}.value"] = 'required';
                            Log::info("Added step 1 validation rule for field: {$key}", [
                                'field_type' => $field['type'] ?? 'unknown',
                                'field_value' => $field['value'],
                                'is_empty' => empty($field['value'])
                            ]);
                        }
                        $this->messages["templateData.{$key}.value.required"] = "The {$field['title']} field is required";
                    }
                }
            }
        } elseif ($this->currentStep == 2) {
            // Step 2: Job details - include basic fields
            $rules = [
                'title' => 'required|min:5',
                'description' => 'required|min:20',
                'average_completion_minutes' => 'required|numeric|min:1',
                'requirements' => 'nullable|array',
            ];

            // Add validation rules for required template fields
            if (!empty($this->templateData)) {
                Log::info("Template data for validation:", $this->templateData);
                foreach ($this->templateData as $key => $field) {
                    if ($field['required'] ?? false) {
                        // For file fields, check if a file path exists
                        if (isset($field['type']) && $field['type'] === 'file') {
                            // Don't add validation rule for file fields, we'll check manually
                            Log::info("File field detected: {$key}", [
                                'field_type' => $field['type'],
                                'field_value' => $field['value'],
                                'is_empty' => empty($field['value']),
                                'field_structure' => $field
                            ]);
                        } else {
                            $rules["templateData.{$key}.value"] = 'required';
                            Log::info("Added regular validation rule for field: {$key}", [
                                'field_type' => $field['type'] ?? 'unknown',
                                'field_value' => $field['value'],
                                'is_empty' => empty($field['value'])
                            ]);
                        }
                        $this->messages["templateData.{$key}.value.required"] = "The {$field['title']} field is required";
                    }
                }
            }
        } elseif ($this->currentStep == 3) {
            // Step 3: Budget, expiry, review, etc.
            $rules = [
                'expiry_date' => 'nullable|date|after:today',
                'budget_per_submission' => 'required|numeric|min:' . $this->min_budget_per_submission,
                'number_of_submissions' => 'required|numeric|min:1',
                'review_type' => 'required',
                'visibility' => 'required|in:public,private',
                'allow_multiple_submissions' => 'boolean',
            ];
        } elseif ($this->currentStep == 4) {
            // Step 4: Review/confirmation
            $rules = [
                'terms' => 'accepted',
            ];
        }
        return $rules;
    }

    public function mount()
    {
        $user = Auth::user();
        $country = Country::find($user->country_id);
        $this->currency = $country->currency;
        $this->currency_symbol = $country->currency_symbol;
        $this->requirements = [];
        $this->platforms = Platform::where('is_active', true)->get();
        $this->templates = PlatformTemplate::where('is_active', true)
            ->whereHas('countryPrices', function($q) use ($user) {
                $q->where('country_id', $user->country_id);
            })->get();
        // Determine approved countries using Country model methods
        $this->countries = Country::orderBy('name')->get();
        $this->countrySetting = $country->setting;

        // Set pricing and other settings if available
        $this->hasFeaturedSubscription = $this->hasFeaturedInSubscription();
        $this->hasBroadcastSubscription = $this->hasBroadcastInSubscription();
        $this->featured = $this->hasFeaturedSubscription;
        $this->broadcast = $this->hasBroadcastSubscription;

        // Get promotion costs from country settings
        if ($this->countrySetting && isset($this->countrySetting->promotion_settings)) {
            $this->featuredPrice = $this->hasFeaturedSubscription ? 0 : ($this->countrySetting->promotion_settings['feature_rate'] ?? 0);
            $this->broadcastPrice = $this->hasBroadcastSubscription ? 0 : ($this->countrySetting->promotion_settings['broadcast_rate'] ?? 0);
        }

        // Get tax and transaction charges from country settings
        if ($this->countrySetting && isset($this->countrySetting->transaction_settings)) {
            $transactionSettings = $this->countrySetting->transaction_settings;
            $this->tax_rate = $transactionSettings['tax']['percentage'] ?? 0;
            $charges = $transactionSettings['charges'] ?? [];
            $this->transactionPercentage = $charges['percentage'] ?? 0;
            $this->transactionFixed = $charges['fixed'] ?? 0;
            $this->transactionCap = $charges['cap'] ?? 0;
        }
        $this->min_budget_per_submission = 0;
        if ($this->template_id) {
            $template = PlatformTemplate::find($this->template_id);
            if ($template) {
                $this->min_budget_per_submission = $template->prices->firstWhere('country_id', $user->country_id)->amount;
            }
        }
        // Set budget_per_submission and expected_budget to minimum on first visit
        if (!$this->budget_per_submission || $this->budget_per_submission < $this->min_budget_per_submission) {
            $this->budget_per_submission = $this->min_budget_per_submission;
        }
        $this->expected_budget = $this->budget_per_submission * 1;
        $this->enable_system_submission_review = (bool) Setting::getValue('enable_system_submission_review', false);

        // Get review costs from country settings
        if ($this->countrySetting && isset($this->countrySetting->review_settings)) {
            $this->adminReviewCost = $this->countrySetting->review_settings['admin_review_cost'] ?? 0;
            $this->systemReviewCost = $this->countrySetting->review_settings['system_review_cost'] ?? 0;
        }

        $this->updateReviewFee();
        $this->updateTotals();
    }
    
    public function nextStep()
    {
        
        try {
            Log::info("Starting nextStep validation for step: " . $this->currentStep);
            $rules = $this->getStepRules();
            Log::info("Validation rules:", $rules);
            Log::info("Current template data:", $this->templateData);
            
            // Manual validation for file fields
            if (!empty($this->templateData)) {
                foreach ($this->templateData as $key => $field) {
                    if (($field['required'] ?? false) && isset($field['type']) && $field['type'] === 'file') {
                        if (empty($field['value'])) {
                            Log::error("File field validation failed for: {$key}", [
                                'field' => $field,
                                'value' => $field['value']
                            ]);
                            $this->addError("templateData.{$key}.value", "The {$field['title']} field is required");
                        } else {
                            Log::info("File field validation passed for: {$key}", [
                                'field' => $field,
                                'value' => $field['value']
                            ]);
                        }
                    }
                }
            }
            
            $this->validate($rules);
            if ($this->currentStep < $this->totalSteps) {
                $this->currentStep++;
                if($this->currentStep == 2){
                    Log::info('Step 2 now');
                    $this->dispatch('step2-shown');
                }
            } elseif ($this->currentStep == $this->totalSteps) {
                // On final step, submit the job
                $this->submitJob();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Validation failed:", [
                'errors' => $e->validator->errors()->toArray(),
                'step' => $this->currentStep,
                'template_data' => $this->templateData
            ]);
            $this->dispatch('validationErrors', $e->validator->errors()->toArray());
            throw $e;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            if($this->currentStep == 1){
                Log::info('Step 1 now');
                $this->dispatch('step1-shown');
            }
            if($this->currentStep == 2){
                $this->dispatch('step2-shown');
            }
        }
    }
    
    #[On('choiceSelected')]
    public function handleChoiceSelected($id,$values)
    {
        if ($id === 'selectedTemplate') {
            // Handle template selection
            $this->template_id = is_array($values) ? ($values[0] ?? null) : $values;
            $this->selectTemplate();
            // Dispatch event to TaskTemplateFields component
        } elseif ($id === 'toolsSelect') {
            // Handle tools selection
            $this->requirements = is_array($values) ? $values : ($values ? [$values] : []);
        } elseif ($id === 'countriesSelect') {
            // Handle countries selection
            $this->task_countries = is_array($values) ? $values : ($values ? [$values] : []);
        }
    }

    public function selectTemplate()
    {
        $this->isTemplateLoading = true;
        $this->templateFieldsLoaded = false;

        $template = PlatformTemplate::find($this->template_id);
        if ($template) {
            $user = Auth::user();
            $this->min_budget_per_submission = $template->countryPrices->firstWhere('country_id', $user->country_id)->amount;
            if ($this->budget_per_submission < $this->min_budget_per_submission) {
                $this->budget_per_submission = $this->min_budget_per_submission;
            }
            $this->updateTotals();
        }
        $this->dispatch('templateSelected', templateId:$this->template_id);
    }
    
    /**
     * Handle template fields loaded event from child component
     */
    public function handleTemplateFieldsLoaded($templateFieldValues)
    {
        // Always set the full array, not just those with values
        Log::info($templateFieldValues);
        $this->templateData = $templateFieldValues;
        $this->isTemplateLoading = false;
        $this->templateFieldsLoaded = true;
    }
    
    /**
     * Handle template field updated event from child component
     */
    public function handleTemplateFieldUpdated($key, $value, $allValues)
    {
        Log::info("Received templateFieldUpdated event:", [
            'key' => $key,
            'value' => $value,
            'allValues' => $allValues
        ]);
        $this->templateData = $allValues;
    }



    public function updateTotals()
    {
        // Get promotion costs from country settings
        if ($this->countrySetting && isset($this->countrySetting->promotion_settings)) {
            $this->featuredPrice = $this->hasFeaturedSubscription ? 0 : ($this->countrySetting->promotion_settings['feature_rate'] ?? 0);
            $this->broadcastPrice = $this->hasBroadcastSubscription ? 0 : ($this->countrySetting->promotion_settings['broadcast_rate'] ?? 0);
        }

        $this->expected_budget = ($this->budget_per_submission ?? 0) * $this->number_of_submissions;
        $baseAmount = $this->expected_budget;

        // Calculate featured amount - if user has subscription, use remaining days, otherwise use selected days
        if ($this->featured) {
            if ($this->hasFeaturedSubscription) {
                $this->featured_days = $this->featuredSubscriptionDaysRemaining;
                $this->featured_amount = 0; // Free for subscribers
            } else {
                $this->featured_amount = $this->featuredPrice * $this->featured_days;
            }
        } else {
            $this->featured_amount = 0;
        }
        $baseAmount += $this->featured_amount;

        // Calculate broadcast amount
        $this->broadcast_amount = $this->broadcast ? ($this->hasBroadcastSubscription ? 0 : ($this->broadcastPrice * $this->number_of_submissions)) : 0;
        $baseAmount += $this->broadcast_amount;

        $this->review_fee = 0;
        $submissions = ($this->number_of_submissions && $this->number_of_submissions > 0) ? $this->number_of_submissions : 1;
        $this->showSystemReviewRefundNote = false;
        if ($this->review_type === 'admin_review') {
            $this->review_fee = $this->adminReviewCost * $submissions;
        } elseif ($this->review_type === 'system_review') {
            $this->review_fee = $this->systemReviewCost * $submissions;
        } elseif ($this->review_type === 'self_review') {
            $this->review_fee = $this->adminReviewCost * $submissions;
            $this->showSystemReviewRefundNote = true;
        }
        $baseAmount += $this->review_fee;
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
    
    public function increaseSubmissions()
    {
        $this->number_of_submissions++;
        $this->updateTotals();
    }
    
    public function decreaseSubmissions()
    {
        if ($this->number_of_submissions > 1) {
            $this->number_of_submissions--;
            $this->updateTotals();
        }
    }
    
    
    public function convertTimeToMinutes()
    {
        $minutes = $this->average_completion_minutes;
        
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
        try {
            // Only require template_id and platform_id (from template)
            if (!$this->template_id) {
                $this->addError('template_id', 'Please select a template.');
                return;
            }
            $template = PlatformTemplate::find($this->template_id);
            if (!$template) {
                $this->addError('template_id', 'Invalid template selected.');
                return;
            }

            DB::beginTransaction();
            
            $task = $this->saveTask(false, false);

            // Save promotions if selected
            if ($this->featured) {
                $promotion = $this->createPromotion($task->id, 'featured');
            }
            if ($this->broadcast) {
                $promotion = $this->createPromotion($task->id, 'broadcast');
            }
            
            DB::commit();
            
            Log::info('Task saved as draft successfully', [
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'template_id' => $this->template_id
            ]);
            
            return redirect()->route('tasks.posted');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to save task as draft', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'template_id' => $this->template_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->addError('general', 'Failed to save draft. ' . $e->getMessage());
            return;
        }
    }
    
    public function submitJob()
    {
        try {
            $this->validate($this->getStepRules());

            // Calculate total budget based on per person budget
            $this->updateTotals();

            DB::beginTransaction();

            // Create the task
            $task = $this->saveTask(true, true);

            $order = Order::create(['user_id' => Auth::id()]);
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $task->id,
                'orderable_type' => get_class($task),
                'amount' => $this->total - ($this->featured_amount + $this->broadcast_amount),
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

            if ($this->broadcast) {
                $promotion = $this->createPromotion($task->id, 'broadcast');
                OrderItem::create([
                    'order_id' => $order->id,
                    'orderable_id' => $promotion->id,
                    'orderable_type' => get_class($promotion),
                    'amount' => $this->broadcast_amount,
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
            
            if (!$link) {
                throw new \Exception('Failed to initiate payment. Please try again.');
            }

            DB::commit();
            
            Log::info('Task submitted successfully', [
                'task_id' => $task->id,
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'user_id' => Auth::id()
            ]);
            
            // Redirect to payment gateway
            return redirect()->to($link);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            Log::error('Validation failed during job submission', [
                'errors' => $e->validator->errors()->toArray(),
                'user_id' => Auth::id()
            ]);
            
            $this->dispatch('validationErrors', $e->validator->errors()->toArray());
            throw $e;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to submit job', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'template_id' => $this->template_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->addError('general', 'Failed to submit job. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    private function saveTask($isActive = false, $convertTime = false)
    {
        $task = new Task();
        $task->user_id = Auth::id();
        $task->platform_template_id = $this->template_id ?? 1;
        $task->platform_id = PlatformTemplate::find($this->template_id)->platform_id;
        $task->title = $this->title;
        $task->description = $this->description;
        $task->average_completion_minutes = $convertTime ? $this->convertTimeToMinutes() : $this->average_completion_minutes;
        $task->expected_budget = $this->expected_budget;
        $task->requirements = $this->requirements;
        $task->number_of_submissions = $this->number_of_submissions;
        $task->allow_multiple_submissions = $this->allow_multiple_submissions;
        $task->visibility = $this->visibility;
        $task->budget_per_submission = $this->budget_per_submission;
        $task->expiry_date = $this->expiry_date;
        $task->task_countries = $this->task_countries;
        $task->submission_review_type = $this->review_type;
        $task->restriction = $this->restriction == 'all' ? null : $this->restriction;
        $task->is_active = $isActive;
        
        if (!empty($this->templateData)) {
            // Sanitize template data - ensure file fields contain only string paths, not file objects
            $sanitizedTemplateData = [];
            foreach ($this->templateData as $fieldKey => $fieldData) {
                $sanitizedTemplateData[$fieldKey] = $fieldData;
                
                // If this is a file field with an object value, it means the file wasn't properly processed
                if (isset($fieldData['type']) && $fieldData['type'] === 'file' && isset($fieldData['value'])) {
                    if (is_object($fieldData['value'])) {
                        Log::warning("File field '{$fieldKey}' contains unpersisted file object, clearing value", [
                            'field_key' => $fieldKey,
                            'object_class' => get_class($fieldData['value'])
                        ]);
                        $sanitizedTemplateData[$fieldKey]['value'] = '';
                    } elseif (!is_string($fieldData['value']) || empty($fieldData['value'])) {
                        // Ensure file fields have valid string paths
                        $sanitizedTemplateData[$fieldKey]['value'] = '';
                    }
                }
            }
            $task->template_data = $sanitizedTemplateData;
        }
        $task->save();
        return $task;
    }
    
    protected function createPromotion($taskId, $type)
    {
        return TaskPromotion::create([
            'user_id'=> Auth::id(),
            'type'=> $type,
            'task_id'=> $taskId,
            'days'=> $type === 'featured' ? $this->featured_days : 1,
            'cost'=> $type === 'featured' ? $this->featuredPrice * $this->featured_days : $this->broadcastPrice * $this->number_of_submissions,
            'currency'=> $this->currency
        ]);
    }


    public function updatedReviewType($value)
    {
        $this->updateTotals();
    }

    public function updateReviewFee()
    {
        $this->review_fee = 0;
        if ($this->review_type === 'admin_review') {
            $this->review_fee = $this->adminReviewCost;
        } elseif ($this->review_type === 'system_review') {
            $this->review_fee = $this->systemReviewCost;
        } elseif ($this->review_type === 'self_review') {
            $this->review_fee = $this->adminReviewCost;
        }
    }

    public function getReviewLabelProperty()
    {
        if ($this->review_type === 'admin_review') {
            return 'Admin-Monitored (' . $this->currency_symbol . number_format($this->adminReviewCost, 2) . ')';
        } elseif ($this->review_type === 'system_review') {
            return 'System-Automated (' . $this->currency_symbol . number_format($this->systemReviewCost, 2) . ')';
        } elseif ($this->review_type === 'self_review') {
            return 'Self-Monitored (' . $this->currency_symbol . number_format($this->adminReviewCost, 2) . ' - Refundable)';
        }
        return 'Self-Monitored (Free)';
    }

    public function updatedBudgetPerSubmission($value)
    {
        if ($value === '' || !is_numeric($value) || $value < $this->min_budget_per_submission) {
            $this->budget_per_submission = $this->min_budget_per_submission;
        }
        $this->updateTotals();
    }

    public function updatedNumberOfSubmissions($value)
    {
        if ($value === '' || !is_numeric($value) || $value < 1) {
            $this->number_of_submissions = 1;
        }
        $this->updateTotals();
    }

    public function updatedRestriction($value)
    {
        // Dispatch event to initialize countries select when restriction changes
        $this->dispatch('restriction-changed');
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
        return view('livewire.tasks.task-create');
    }

    public function hasFeaturedInSubscription()
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        // Check for active subscription with 'feature-all-tasks' booster
        $subscription = \App\Models\Subscription::where('user_id', $user->id)
            ->where('booster_id', \App\Models\Booster::where('slug', 'feature-all-tasks')->first()?->id)
            ->where('expires_at', '>', now())
            ->first();

        if ($subscription) {
            $this->featuredSubscriptionDaysRemaining = intval(now()->diffInDays($subscription->expires_at));
            return true;
        }
        return false;
    }

    public function hasBroadcastInSubscription()
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        // Check for active subscription with 'broadcast-all-tasks' booster
        $subscription = \App\Models\Subscription::where('user_id', $user->id)
            ->where('booster_id', \App\Models\Booster::where('slug', 'broadcast-all-tasks')->first()?->id)
            ->where('expires_at', '>', now())
            ->first();

        return $subscription ? true : false;
    }
}

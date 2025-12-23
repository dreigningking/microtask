<?php

namespace App\Livewire\Tasks;

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
use App\Models\TaskPromotion;
use Livewire\WithFileUploads;
use App\Models\CountrySetting;
use Livewire\Attributes\Layout;
use App\Models\PlatformTemplate;
use App\Http\Traits\PaymentTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\GeoLocationTrait;


class TaskEdit extends Component
{
    use WithFileUploads, GeoLocationTrait, PaymentTrait;

    // Step tracking
    public $currentStep = 1;
    public $totalSteps = 4;

    // Template loading state
    public $isTemplateLoading = false;
    public $templateFieldsLoaded = false;

    // Task instance
    public Task $task;

    // Data collections
    public $platforms;
    public $templates;
    public $location;
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
    public $files = [];
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
        'average_completion_minutes' => 'required|numeric|min:1',
        'description' => 'required|min:20',
        'requirements' => 'nullable|array',
        'budget_per_submission' => 'required|numeric|min:0',
        'number_of_submissions' => 'required|numeric|min:1',
        'review_type' => 'required',
        'visibility' => 'required|in:public,private',
        'expiry_date' => 'nullable|date|after:today',
        'allow_multiple_submissions' => 'boolean',
        'terms' => 'accepted',
    ];

    // Validation messages
    protected $messages = [
        'title.required' => 'Please enter a job title',
        'description.required' => 'Please provide a job description',
        'requirements.required' => 'Please enter at least one required skill',
        'budget_per_submission.required' => 'Please enter a budget per person',
    ];

    public $min_budget_per_submission = 0;
    public $review_fee = 0;
    public $enable_system_review = false;
    public $showSystemReviewRefundNote = false;
    public $enable_system_submission_review = false;
    public $adminReviewCost = 0;
    public $systemReviewCost = 0;
    public $hasBroadcastSubscription = false;
    public $featuredSubscriptionDaysRemaining = 0;

    public $serviceUnavailable = false;
    public $unavailableCountryName = null;

    public static $allowedFileTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    public $isPaid = false;
    public $hasWorkers = false;
    public $canEditAll = false;
    public $canEditSome = false;
    public $canEditNone = false;
    public $canEdit = false; // New property to track if job can be edited
    public $hasFeaturedSubscription = false;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->location = $this->getLocation();
        $this->currency = $this->location->currency;
        $this->currency_symbol = $this->location->currency_symbol;
        $this->requirements = [];
        $this->platforms = Platform::where('is_active', true)->get();
        $this->templates = PlatformTemplate::where('is_active', true)
            ->whereHas('countryPrices', function($q) {
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
        $this->countries = $allCountries; // Use all countries for select

        // Set countrySetting for the user's/guest's country if available
        $country = Country::find($this->location->country_id);
        $this->countrySetting = $country ? $country->setting : null;

        // If user's/guest's country is not approved, set serviceUnavailable
        if (!$approvedCountries->pluck('id')->contains($this->location->country_id)) {
            $this->serviceUnavailable = true;
            $this->unavailableCountryName = $this->location->country_name ?? 'your country';
        }

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
                $this->min_budget_per_submission = $template->countryPrices->firstWhere('country_id', $this->location->country_id)->amount;
            }
        }
        // Set budget_per_submission and expected_budget to minimum on first visit
        if (!$this->budget_per_submission || $this->budget_per_submission < $this->min_budget_per_submission) {
            $this->budget_per_submission = $this->min_budget_per_submission;
        }
        $this->expected_budget = $this->budget_per_submission * 1;
        $this->enable_system_review = (bool) Setting::getValue('enable_system_review', false);
        $this->enable_system_submission_review = (bool) Setting::getValue('enable_system_submission_review', false);

        // Get review costs from country settings
        if ($this->countrySetting && isset($this->countrySetting->review_settings)) {
            $this->adminReviewCost = $this->countrySetting->review_settings['admin_review_cost'] ?? 0;
            $this->systemReviewCost = $this->countrySetting->review_settings['system_review_cost'] ?? 0;
        }

        // Load task data into component properties
        $this->loadTaskData();

        $this->updateReviewFee();
        $this->updateTotals();

        // Check payment and worker status
        $this->checkEditPermissions();
    }

    private function loadTaskData()
    {
        // Load basic information
        $this->title = $this->task->title;
        $this->platform_id = $this->task->platform_id;
        $this->template_id = $this->task->platform_template_id;
        $this->description = $this->task->description;
        $this->average_completion_minutes = $this->task->average_completion_minutes;
        $this->budget_per_submission = $this->task->budget_per_submission;
        $this->number_of_submissions = $this->task->number_of_submissions;
        $this->visibility = $this->task->visibility;
        $this->expiry_date = $this->task->expiry_date ? $this->task->expiry_date->format('Y-m-d') : null;
        $this->review_type = $this->task->submission_review_type;
        $this->task_countries = $this->task->task_countries ?? [];
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
            } elseif ($promotion->type === 'broadcast') {
                $this->broadcast = true;
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
        $this->hasWorkers = $this->task->taskWorkers()->count() > 0;

        // Determine edit permissions
        if ($this->hasWorkers) {
            // Task cannot be edited if it already has workers
            $this->canEditAll = false;
            $this->canEditSome = false;
            $this->canEditNone = true;
            $this->canEdit = false;
        } elseif ($this->isPaid) {
            // Task has been paid for but no workers yet - can edit some fields but not budget/preferences
            $this->canEditAll = false;
            $this->canEditSome = true; // Can edit basic details but not budget/preferences
            $this->canEditNone = false;
            $this->canEdit = true;
        } else {
            // Task not paid and no workers - can edit everything
            $this->canEditAll = true;
            $this->canEditSome = false;
            $this->canEditNone = false;
            $this->canEdit = true;
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
        if($element == 'task_countries'){
            $this->task_countries = $data;
        }
    }

    #[On('choiceSelected')]
    public function handleChoiceSelected($id, $values)
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
            $this->min_budget_per_submission = $template->countryPrices->firstWhere('country_id', $this->location->country_id)->amount;
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
    
    public function submitJob()
    {
        // Check if job can be edited
        if (!$this->canEdit) {
            session()->flash('error', 'This job has been paid for and cannot be modified.');
            return;
        }

        $this->validate();

        // Calculate total budget based on per person budget
        $this->updateTotals();

        DB::beginTransaction();

        try {
            // Update the existing task
            $this->task->user_id = Auth::id();
            $this->task->platform_template_id = $this->template_id ?? 1;
            $this->task->platform_id = PlatformTemplate::find($this->template_id)->platform_id;
            $this->task->title = $this->title;
            $this->task->description = $this->description;
            $this->task->average_completion_minutes = $this->convertTimeToMinutes();
            $this->task->expected_budget = $this->expected_budget;
            $this->task->requirements = $this->requirements;
            $this->task->number_of_submissions = $this->number_of_submissions;
            $this->task->visibility = $this->visibility;
            $this->task->budget_per_submission = $this->budget_per_submission;
            $this->task->expiry_date = $this->expiry_date;
            $this->task->submission_review_type = $this->review_type;
            $this->task->task_countries = $this->task_countries;
            $this->task->restriction = $this->restriction == 'all' ? null : $this->restriction;
            $this->task->is_active = true;
            $this->task->allow_multiple_submissions = $this->allow_multiple_submissions;

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
                $this->task->template_data = $sanitizedTemplateData;
            }

            $this->task->save();

            // Handle promotions - only create new ones if they don't exist
            $this->handlePromotions();

            if (!$this->isPaid) {
                session()->flash('success', 'Job updated successfully! Redirecting to payment...');

                $order = Order::create(['user_id' => Auth::id()]);
                OrderItem::create([
                    'order_id' => $order->id,
                    'orderable_id' => $this->task->id,
                    'orderable_type' => get_class($this->task),
                    'amount' => $this->total - ($this->featured_amount + $this->broadcast_amount),
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
                    'gateway_id' => $this->countrySetting->gateway_id,
                    'status' => 'pending',
                ]);

                $link = $this->initializePayment($payment);
                if (!$link) {
                    throw new \Exception('Failed to initiate payment. Please try again.');
                }

                DB::commit();

                // Redirect to payment gateway
                return redirect()->to($link);
            } else {
                DB::commit();
                session()->flash('success', 'Job updated successfully!');
                return redirect()->route('tasks.posted');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update job', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'task_id' => $this->task->id,
                'trace' => $e->getTraceAsString()
            ]);
            $this->addError('general', 'Failed to update job. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function saveAsDraft()
    {
        // Check if task has workers - cannot save as draft if it has workers
        if ($this->hasWorkers) {
            session()->flash('error', 'Cannot save as draft - task already has workers.');
            return;
        }

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

            $this->task->user_id = Auth::id();
            $this->task->platform_template_id = $this->template_id ?? 1;
            $this->task->platform_id = PlatformTemplate::find($this->template_id)->platform_id;
            $this->task->title = $this->title;
            $this->task->description = $this->description;
            $this->task->average_completion_minutes = $this->convertTimeToMinutes();
            $this->task->expected_budget = $this->expected_budget;
            $this->task->requirements = $this->requirements;
            $this->task->number_of_submissions = $this->number_of_submissions;
            $this->task->visibility = $this->visibility;
            $this->task->budget_per_submission = $this->budget_per_submission;
            $this->task->expiry_date = $this->expiry_date;
            $this->task->submission_review_type = $this->review_type;
            $this->task->task_countries = $this->task_countries;
            $this->task->restriction = $this->restriction == 'all' ? null : $this->restriction;
            $this->task->is_active = false;

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
                $this->task->template_data = $sanitizedTemplateData;
            }

            $this->task->save();

            // Save promotions if selected
            if ($this->featured) {
                $promotion = $this->createPromotion($this->task->id, 'featured');
            }
            if ($this->broadcast) {
                $promotion = $this->createPromotion($this->task->id, 'broadcast');
            }

            DB::commit();

            Log::info('Task saved as draft successfully', [
                'task_id' => $this->task->id,
                'user_id' => Auth::id(),
                'template_id' => $this->template_id
            ]);

            session()->flash('success', 'Task saved as draft successfully!');
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

    private function handlePromotions()
    {
        // Delete existing promotions
        $this->task->promotions()->delete();
        
        // Create new promotions if selected
        if ($this->featured) {
            $this->createPromotion($this->task->id, 'featured');
        }
        if ($this->broadcast) {
            $this->createPromotion($this->task->id, 'broadcast');
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
        
        if ($this->broadcast) {
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $this->task->promotions()->where('type', 'broadcast')->first()->id,
                'orderable_type' => TaskPromotion::class,
                'amount' => $this->broadcast_amount,
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

    public function updatedFeaturedDays($value)
    {
        if ($value === '' || !is_numeric($value) || $value < 1) {
            $this->featured_days = 1;
        }
        $this->updateTotals();
    }

    public function updatedRestriction($value)
    {
        // Dispatch event to initialize countries select when restriction changes
        $this->dispatch('restriction-changed');
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
        // For now, return false - this can be implemented later when subscription system is ready
        return false;
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

    public function render()
    {
        return view('livewire.tasks.task-edit');
    }
}


<?php

namespace App\Livewire\DashboardArea\Jobs;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\TaskTemplate;
use Livewire\Attributes\On; 
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Log;

class TemplateFields extends Component
{
    use WithFileUploads;

    public $templateId;
    public $templateFields = [];
    public $templateData = [];
    public $validationErrors = [];
    
    protected $listeners = [
        'validationErrors' => 'handleValidationErrors'
    ];
    
    /**
     * Load fields from the selected template
     */
    #[On('templateSelected')] 
    public function loadTemplateFields($templateId)
    {
        \Log::info($templateId);
        $this->templateId = $templateId;
        
        // Reset template fields
        $this->templateFields = [];
        $this->templateData = [];
        $this->validationErrors = [];
        
        if (!empty($templateId)) {
            $template = TaskTemplate::find($templateId);
            
            if ($template && !empty($template->task_fields)) {
                $taskFields = $template->task_fields;
                if ($taskFields) {
                    // Store template fields for rendering in the view
                    $this->templateFields = $taskFields;
                    // Initialize field values
                    foreach ($taskFields as $field) {
                        log($field);
                        if (isset($field['title'])) {
                            $this->templateData[$field['name']] = [
                                'value' => '',
                                'name' => $field['name'],
                                'required' => $field['required'] ?? false,
                                'title' => $field['title'],
                                'type' => $field['type'] ?? 'text'
                            ];
                        }
                    }
                }
            }
        }
        // Always dispatch the full templateData array, even if empty
        $this->dispatch('templateFieldsLoaded', $this->templateData);
    }
    
    /**
     * Update a template field value
     */
    public function updateField($key, $value)
    {
        if (isset($this->templateData[$key])) {
            // Handle file upload
            if (is_object($value) && method_exists($value, 'getClientOriginalName')) {
                // Validate file type and size
                $this->validate([
                    "templateData.$key.value" => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,mov,avi,wmv,mkv'
                ], [
                    "templateData.$key.value.mimes" => "Invalid file type for {$this->templateData[$key]['title']}"
                ]);
                // Store file
                $path = $value->store('tasks/template-fields', 'public');
                $this->templateData[$key]['value'] = 'storage/' . $path;
            } else {
                $this->templateData[$key]['value'] = $value;
            }

            // Clear validation error for this field if it exists
            if (isset($this->validationErrors["templateData.{$key}.value"])) {
                unset($this->validationErrors["templateData.{$key}.value"]);
            }

            // Dispatch event to notify parent component
            $this->dispatch('templateFieldUpdated', $key, $this->templateData[$key]['value'], $this->templateData);
        }
    }

    /**
     * Handle validation errors from parent component
     */
    public function handleValidationErrors($errors)
    {
        $this->validationErrors = $errors;
    }
    
    public function mount()
    {
        if ($this->templateId) {
            $this->loadTemplateFields($this->templateId);
        }
    }

    public function updatedTemplateId()
    {
        if ($this->templateId) {
            $this->loadTemplateFields($this->templateId);
        }
    }

    public function render()
    {
        return view('livewire.dashboard-area.jobs.template-fields');
    }
}

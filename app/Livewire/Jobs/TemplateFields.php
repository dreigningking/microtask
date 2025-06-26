<?php

namespace App\Livewire\Jobs;

use App\Models\TaskTemplate;
use Illuminate\Support\Str;
use Livewire\Component;

class TemplateFields extends Component
{
    public $templateId;
    public $templateFields = [];
    public $templateData = [];
    public $validationErrors = [];
    
    protected $listeners = [
        'templateSelected' => 'loadTemplateFields',
        'validationErrors' => 'handleValidationErrors'
    ];
    
    /**
     * Load fields from the selected template
     */
    public function loadTemplateFields($templateId)
    {
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
            $this->templateData[$key]['value'] = $value;
            
            // Clear validation error for this field if it exists
            if (isset($this->validationErrors["templateData.{$key}.value"])) {
                unset($this->validationErrors["templateData.{$key}.value"]);
            }
            
            // Dispatch event to notify parent component
            $this->dispatch('templateFieldUpdated', $key, $value, $this->templateData);
        }
    }

    /**
     * Handle validation errors from parent component
     */
    public function handleValidationErrors($errors)
    {
        $this->validationErrors = $errors;
    }
    
    public function render()
    {
        return view('livewire.jobs.template-fields');
    }
}

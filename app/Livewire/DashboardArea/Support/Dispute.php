<?php

namespace App\Livewire\DashboardArea\Support;

use App\Models\Support;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Dispute extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $status = 'all';
    public $showCreateModal = false;
    
    // Form properties for creating tickets
    public $subject = '';
    public $description = '';
    public $priority = 'normal';
    public $attachments = [];
    
    // Stats
    public $stats = [
        'total' => 0,
        'open' => 0,
        'in_progress' => 0,
        'closed' => 0
    ];

    protected $rules = [
        'subject' => 'required|min:5|max:255',
        'description' => 'required|min:20',
        'priority' => 'required|in:low,normal,high,critical',
    ];

    protected $messages = [
        'subject.required' => 'Please enter a ticket subject',
        'subject.min' => 'Subject must be at least 5 characters',
        'description.required' => 'Please provide a detailed description',
        'description.min' => 'Description must be at least 20 characters',
        'priority.required' => 'Please select a priority level',
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();
        
        $this->stats['total'] = Support::where('user_id', $userId)->count();
        $this->stats['open'] = Support::where('user_id', $userId)->where('status', 'open')->count();
        $this->stats['in_progress'] = Support::where('user_id', $userId)->where('status', 'in_progress')->count();
        $this->stats['closed'] = Support::where('user_id', $userId)->where('status', 'closed')->count();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->resetForm();
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->subject = '';
        $this->description = '';
        $this->priority = 'normal';
        $this->attachments = [];
        $this->resetErrorBag();
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function createTicket()
    {
        $this->validate();

        // Validate files manually
        if (!empty($this->attachments)) {
            $fileErrors = $this->validateFiles();
            if (!empty($fileErrors)) {
                foreach ($fileErrors as $error) {
                    $this->addError('attachments', $error);
                }
                return;
            }
        }

        // Create the support ticket
        $support = Support::create([
            'user_id' => Auth::id(),
            'subject' => $this->subject,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => 'open'
        ]);

        // Create the first comment (same as description)
        $commentData = [
            'user_id' => Auth::id(),
            'body' => $this->description
        ];

        // Handle file uploads if any
        if (!empty($this->attachments)) {
            $processedAttachments = $this->processAttachments();
            if (!empty($processedAttachments)) {
                $commentData['attachments'] = json_encode($processedAttachments);
            }
        }

        $support->comments()->create($commentData);

        $this->closeCreateModal();
        $this->loadStats();
        
        session()->flash('success', 'Support ticket created successfully!');
    }

    private function validateFiles()
    {
        $errors = [];
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes

        Log::info('Validating files:', [
            'count' => count($this->attachments),
            'attachments' => $this->attachments
        ]);

        foreach ($this->attachments as $index => $file) {
            Log::info('Processing file:', [
                'index' => $index,
                'file_class' => get_class($file),
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension(),
                'file_mime' => $file->getMimeType()
            ]);

            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Check file size
                if ($file->getSize() > $maxSize) {
                    $errors[] = "File '{$file->getClientOriginalName()}' exceeds the maximum size of 5MB.";
                }

                // Check file extension
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedTypes)) {
                    $errors[] = "File '{$file->getClientOriginalName()}' is not a supported file type. Allowed types: " . implode(', ', $allowedTypes);
                }
            } else {
                $errors[] = "File '{$file->getClientOriginalName()}' is not a valid file upload.";
            }
        }

        Log::info('File validation result:', [
            'errors' => $errors
        ]);

        return $errors;
    }

    private function processAttachments()
    {
        $processedFiles = [];
        
        foreach ($this->attachments as $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Store the file and get the path
                $path = $file->store('support-attachments', 'public');
                
                $processedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'storage/' . $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString()
                ];
            }
        }
        
        return $processedFiles;
    }

    public function getTicketsQuery()
    {
        $query = Support::where('user_id', Auth::id())
            ->when($this->search, function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('subject', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== 'all', function($q) {
                $q->where('status', $this->status);
            });

        return $query;
    }

    public function render()
    {
        $tickets = $this->getTicketsQuery()
            ->with(['user', 'comments'])
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard-area.support.dispute', [
            'tickets' => $tickets
        ]);
    }
}

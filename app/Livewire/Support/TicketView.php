<?php
    
namespace App\Livewire\Support;

use App\Models\Support;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TicketView extends Component
{
    use WithFileUploads;

    public Support $support;
    public $newComment = '';
    public $attachments = [];

    protected $rules = [
        'newComment' => 'required|min:5',
    ];

    protected $messages = [
        'newComment.required' => 'Please enter a comment',
        'newComment.min' => 'Comment must be at least 5 characters',
    ];

    public function mount(Support $support)
    {
        $this->support = $support->load(['user', 'comments.user']);
    }

    public function markInProgress()
    {
        // Only admins can mark tickets in progress
        if (!Auth::user()->role_id) {
            session()->flash('error', 'You do not have permission to perform this action.');
            return;
        }

        $this->support->update(['status' => 'in_progress']);
        $this->support->refresh();
        
        session()->flash('success', 'Ticket marked as in progress.');
    }

    public function closeTicket()
    {
        // Users can only close their own tickets, admins can close any ticket
        if (Auth::id() !== $this->support->user_id && !Auth::user()->role_id) {
            session()->flash('error', 'You can only close your own tickets.');
            return;
        }

        $this->support->update(['status' => 'closed']);
        $this->support->refresh();
        
        session()->flash('success', 'Ticket closed successfully.');
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function addComment()
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

        // Create new comment
        $commentData = [
            'user_id' => Auth::id(),
            'body' => $this->newComment
        ];

        // Handle file uploads if any
        if (!empty($this->attachments)) {
            $processedAttachments = $this->processAttachments();
            if (!empty($processedAttachments)) {
                $commentData['attachments'] = json_encode($processedAttachments);
            }
        }

        $comment = $this->support->comments()->create($commentData);

        // Reset form
        $this->newComment = '';
        $this->attachments = [];
        $this->resetErrorBag();

        // Refresh ticket data
        $this->support->refresh();
        
        session()->flash('success', 'Comment added successfully!');
    }

    private function validateFiles()
    {
        $errors = [];
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes

        foreach ($this->attachments as $index => $file) {
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
            }
        }

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

    public function render()
    {
        return view('livewire.support.ticket-view');
    }
}

<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('support') }}" class="text-decoration-none">Support Tickets</a></li>
                            <li class="breadcrumb-item active">Ticket #{{ $ticket->id }}</li>
                        </ol>
                    </nav>
                    <h1 class="h4 mb-2">{{ $ticket->subject }}</h1>
                    <div class="d-flex gap-3 align-items-center">
                        <span class="badge bg-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <span class="badge bg-{{ $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'normal' ? 'info' : 'success')) }} fs-6">
                            {{ ucfirst($ticket->priority) }} Priority
                        </span>
                        <span class="text-muted">Created {{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('support') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back to Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Ticket Details -->
        <div class="col-lg-8">
            <!-- Ticket Description -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fa fa-file-text-o me-2 text-primary"></i>
                        Ticket Description
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-0">{{ $ticket->description }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fa fa-user me-1"></i>
                            {{ $ticket->user->name ?? $ticket->user->username }}
                        </small>
                        <small class="text-muted">
                            <i class="fa fa-clock-o me-1"></i>
                            {{ $ticket->created_at->format('M j, Y \a\t g:i A') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fa fa-comments me-2 text-primary"></i>
                        Comments ({{ $ticket->comments->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($ticket->comments as $comment)
                    <div class="comment mb-4 {{ $loop->last ? 'mb-0' : '' }}">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fa fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="fw-semibold">{{ $comment->user->name ?? $comment->user->username }}</span>
                                        @if($comment->user_id === $ticket->user_id)
                                        <span class="badge bg-primary bg-opacity-10 text-white ms-2">You</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="comment-content mb-2">
                                    <p class="mb-0">{{ $comment->body }}</p>
                                </div>
                                @if($comment->attachments)
                                <div class="attachments">
                                    <small class="text-muted">
                                        <i class="fa fa-paperclip me-1"></i>
                                        Attachments:
                                    </small>
                                    <div class="mt-1">
                                        @foreach(json_decode($comment->attachments, true) ?? [] as $attachment)
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            @if(in_array(strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                                <i class="fa fa-image text-primary"></i>
                                                <a href="{{ asset($attachment['path']) }}" target="_blank" class="text-decoration-none">
                                                    {{ $attachment['name'] }}
                                                </a>
                                                <small class="text-muted">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                                            @else
                                                <i class="fa fa-file-text-o text-primary"></i>
                                                <a href="{{ asset($attachment['path']) }}" target="_blank" class="text-decoration-none">
                                                    {{ $attachment['name'] }}
                                                </a>
                                                <small class="text-muted">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                    <hr class="my-3">
                    @endif
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-comments display-4 mb-3"></i>
                        <h6 class="mb-2">No comments yet</h6>
                        <p class="mb-0">Be the first to add a comment to this ticket.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Add Comment Form -->
            @if($ticket->status !== 'closed')
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fa fa-plus me-2 text-primary"></i>
                        Add Comment
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="addComment">
                        <div class="mb-3">
                            <label for="newComment" class="form-label">Your Comment</label>
                            <textarea 
                                wire:model="newComment" 
                                class="form-control {{ $errors->has('newComment') ? 'is-invalid' : '' }}" 
                                id="newComment" 
                                rows="4" 
                                placeholder="Add your comment or update to this ticket..."
                                required
                            ></textarea>
                            @error('newComment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Attachments (Optional)</label>
                            <input type="file" wire:model="attachments" class="form-control" id="attachments" multiple>
                            <div class="form-text">You can attach screenshots or documents (max 5 files, 5MB each). Supported: JPG, PNG, GIF, PDF, DOC, DOCX, TXT</div>
                            @error('attachments') <div class="text-danger small">{{ $message }}</div> @enderror
                            
                            <!-- Show selected files -->
                            @if(!empty($attachments))
                            <div class="mt-2">
                                <small class="text-muted">Selected files:</small>
                                <div class="mt-1">
                                    @foreach($attachments as $index => $file)
                                    <div class="d-flex align-items-center gap-2 mb-1 p-2 bg-light rounded">
                                        <i class="fa fa-file-text-o text-primary"></i>
                                        <span class="small">{{ $file->getClientOriginalName() }}</span>
                                        <button type="button" wire:click="removeAttachment({{ $index }})" class="btn btn-sm btn-outline-danger ms-auto">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane me-1"></i>
                                Add Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                This ticket is closed and no longer accepts new comments.
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Ticket Info -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fa fa-info-circle me-2 text-primary"></i>
                        Ticket Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Status</div>
                                <div class="fw-bold text-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Priority</div>
                                <div class="fw-bold text-{{ $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'normal' ? 'info' : 'success')) }}">
                                    {{ ucfirst($ticket->priority) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ticket ID:</span>
                            <span class="fw-semibold">#{{ $ticket->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created:</span>
                            <span class="fw-semibold">{{ $ticket->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Last Updated:</span>
                            <span class="fw-semibold">{{ $ticket->updated_at->format('M j, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Comments:</span>
                            <span class="fw-semibold">{{ $ticket->comments->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fa fa-tools me-2 text-primary"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('support') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-1"></i>
                            Back to Tickets
                        </a>
                        
                        
                        
                        @if($ticket->status !== 'closed' && Auth::id() === $ticket->user_id)
                        <button wire:click="closeTicket" class="btn btn-danger text-white">
                            <i class="fa fa-check-circle me-1"></i>
                            Close Ticket
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

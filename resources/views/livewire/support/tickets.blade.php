<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Support Center</h1>
                    <p class="mb-0">Get help with your account, tasks, and payments</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                        <button wire:click="openCreateModal" class="btn btn-light">
                            <i class="bi bi-plus-circle"></i> New Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Support Quick Links -->
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-question-circle display-4 text-primary mb-3"></i>
                            <h5>Help Articles</h5>
                            <p class="text-muted">Browse our knowledge base for answers to common questions</p>
                            <a href="{{ route('support.articles') }}" class="btn btn-outline-primary">Browse Articles</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-chat-left-text display-4 text-success mb-3"></i>
                            <h5>Contact Support</h5>
                            <p class="text-muted">Can't find what you need? Create a support ticket</p>
                            <button wire:click="openCreateModal" class="btn btn-outline-primary">
                                Create Ticket
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-telephone display-4 text-warning mb-3"></i>
                            <h5>Live Chat</h5>
                            <p class="text-muted">Chat with our support team in real-time</p>
                            <button class="btn btn-outline-primary">Start Chat</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Total Tickets</h6>
                                <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="bi bi-ticket-detailed text-primary"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Open Tickets</h6>
                                <span class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="bi bi-clock text-warning"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['open'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">In Progress</h6>
                                <span class="bg-info bg-opacity-10 rounded-circle p-2"><i class="bi bi-arrow-repeat text-info"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['in_progress'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Closed</h6>
                                <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="bi bi-check-circle text-success"></i></span>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $stats['closed'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Tickets -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Support Tickets</h5>
                    <div class="d-flex gap-2">
                        <!-- Status Tabs -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" wire:click="$set('status', 'all')" class="btn {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                All ({{ $stats['total'] }})
                            </button>
                            <button type="button" wire:click="$set('status', 'open')" class="btn {{ $status === 'open' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Open ({{ $stats['open'] }})
                            </button>
                            <button type="button" wire:click="$set('status', 'in_progress')" class="btn {{ $status === 'in_progress' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                In Progress ({{ $stats['in_progress'] }})
                            </button>
                            <button type="button" wire:click="$set('status', 'closed')" class="btn {{ $status === 'closed' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Closed ({{ $stats['closed'] }})
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by ticket ID or subject...">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="d-md-none">
                        <div class="row g-3">
                            @forelse($tickets as $ticket)
                            <div class="col-12">
                                <div class="card shadow-sm border-start border-4 border-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">{{ $ticket->subject }}</h5>
                                                <div class="text-muted small">Ticket #{{ $ticket->id }}</div>
                                            </div>
                                            <div>
                                                <span class="badge bg-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 small">
                                                <span class="text-muted">Priority:</span>
                                                <span class="fw-semibold text-{{ $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($ticket->priority) }}
                                                </span>
                                            </div>
                                            <div class="col-6 small">
                                                <span class="text-muted">Created:</span>
                                                <span class="fw-semibold">{{ $ticket->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="col-6 small">
                                                <span class="text-muted">Last Update:</span>
                                                <span class="fw-semibold">{{ $ticket->updated_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="col-6 small">
                                                <span class="text-muted">Comments:</span>
                                                <span class="fw-semibold">{{ $ticket->comments->count() }}</span>
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-3">{{ Str::limit($ticket->description, 100) }}</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('support.ticket', $ticket->id) }}" class="btn btn-primary btn-sm flex-fill">
                                                <i class="bi bi-eye me-1"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-inbox display-4 mb-3"></i>
                                    <h5 class="mb-2">No tickets found</h5>
                                    <p class="mb-0">No support tickets match your current filters.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Last Update</th>
                                    <th>Comments</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                <tr>
                                    <td><span class="fw-semibold text-primary">#{{ $ticket->id }}</span></td>
                                    <td>
                                        <div>
                                            <div class="fw-medium">{{ $ticket->subject }}</div>
                                            <div class="text-muted small">{{ Str::limit($ticket->description, 80) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'normal' ? 'info' : 'success')) }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $ticket->comments->count() }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('support.ticket', $ticket->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-6 mb-3 d-block"></i>
                                        <h5 class="mb-2">No tickets found</h5>
                                        <p class="mb-0">No support tickets match your current filters.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tickets->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted small">
                            Showing <span class="fw-semibold">{{ $tickets->firstItem() }}</span> to <span class="fw-semibold">{{ $tickets->lastItem() }}</span> of <span class="fw-semibold">{{ $tickets->total() }}</span> results
                        </div>
                        <div>
                            {{ $tickets->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Create Ticket Modal -->
    @if($showCreateModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Support Ticket</h5>
                    <button type="button" wire:click="closeCreateModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createTicket">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" wire:model="subject" class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" id="subject" placeholder="Brief description of your issue" required>
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="priority" class="form-label">Priority *</label>
                                <select wire:model="priority" class="form-select {{ $errors->has('priority') ? 'is-invalid' : '' }}" id="priority" required>
                                    <option value="low">Low</option>
                                    <option value="normal">Normal</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                                @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
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
                                        <i class="bi bi-file-earmark text-primary"></i>
                                        <span class="small">{{ $file->getClientOriginalName() }}</span>
                                        <button type="button" wire:click="removeAttachment({{ $index }})" class="btn btn-sm btn-outline-danger ms-auto">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea wire:model="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" rows="5" placeholder="Please provide detailed information about your issue..." required></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" wire:click="closeCreateModal" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
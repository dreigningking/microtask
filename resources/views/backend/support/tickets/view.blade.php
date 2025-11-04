@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Support Ticket #ST-001
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.support.tickets.index') }}">Support Tickets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ticket Details</li>
                </ol>
            </nav>
        </div>

        <!-- Ticket Status Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">{{ $support->subject ?? 'No Subject' }}</h5>
                            <p class="text-muted mb-0">Created by {{ $support->user->name ?? 'Unknown User' }} • {{ $support->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            @if($support->priority)
                                <span class="badge bg-{{ $support->priority === 'high' ? 'danger' : ($support->priority === 'medium' ? 'warning' : 'info') }} fs-6">{{ ucfirst($support->priority) }} Priority</span>
                            @endif
                            <span class="badge bg-{{ $support->status === 'open' ? 'success' : ($support->status === 'in_progress' ? 'warning' : ($support->status === 'resolved' ? 'info' : 'secondary')) }} fs-6">{{ ucfirst(str_replace('_', ' ', $support->status)) }}</span>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="ticketActionDropdown" data-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="ticketActionDropdown">
                                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#escalateModal">
                                        <i class="ri-arrow-up-line me-2"></i>Escalate Ticket
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#changeStatusModal">
                                        <i class="ri-settings-3-line me-2"></i>Change Status
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Customer</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <img src="{{ $support->user->profile_photo_url ?? 'https://randomuser.me/api/portraits/men/32.jpg' }}" alt="Customer" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            <div>
                                <div class="fw-bold">{{ $support->user->name ?? 'Unknown User' }}</div>
                                <div class="text-muted small">{{ $support->user->email ?? 'No email' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Assigned To</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Staff" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            <div>
                                <div class="fw-bold">Sarah Johnson</div>
                                <div class="text-muted small">Support Team</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Messages</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="message-circle"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $support->trails->count() ?? 0 }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Total messages</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Response Time</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="clock"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">2h 15m</h1>
                        <div class="mb-0">
                            <span class="text-muted">Average response</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Messages Section -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Conversation</h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        @forelse($support->trails as $trail)
                            @if($trail->user_id == $support->user_id)
                                <!-- Customer Message -->
                                <div class="d-flex mb-4">
                                    <img src="{{ $support->user->profile_photo_url ?? 'https://randomuser.me/api/portraits/men/32.jpg' }}" alt="Customer" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h6 class="mb-0 me-2">{{ $support->user->name ?? 'Unknown User' }}</h6>
                                            <small class="text-muted">{{ $trail->created_at->format('Y-m-d H:i') }}</small>
                                            <span class="badge bg-secondary ms-2">Customer</span>
                                        </div>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <p class="mb-0">{{ $trail->message ?? 'No message content' }}</p>
                                                @if($trail->attachments)
                                                    <div class="attachment-preview mt-2">
                                                        @foreach(json_decode($trail->attachments) as $attachment)
                                                            <div class="d-flex align-items-center p-2 bg-white rounded border mb-2">
                                                                <i class="ri-image-line text-primary me-2"></i>
                                                                <span class="flex-grow-1">{{ basename($attachment) }}</span>
                                                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Admin Message -->
                                <div class="d-flex mb-4 justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <div class="d-flex align-items-center justify-content-end mb-2">
                                            <span class="badge bg-primary me-2">Support Team</span>
                                            <small class="text-muted me-2">{{ $trail->created_at->format('Y-m-d H:i') }}</small>
                                            <h6 class="mb-0">{{ $trail->user->name ?? 'Support Team' }}</h6>
                                        </div>
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <p class="mb-0">{{ $trail->message ?? 'No message content' }}</p>
                                                @if($trail->attachments)
                                                    <div class="attachment-preview mt-2">
                                                        @foreach(json_decode($trail->attachments) as $attachment)
                                                            <div class="d-flex align-items-center p-2 bg-white rounded border mb-2">
                                                                <i class="ri-image-line text-primary me-2"></i>
                                                                <span class="flex-grow-1">{{ basename($attachment) }}</span>
                                                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{ $trail->user->profile_photo_url ?? 'https://randomuser.me/api/portraits/women/44.jpg' }}" alt="Admin" class="rounded-circle ms-3" style="width: 40px; height: 40px;">
                                </div>
                            @endif
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="ri-message-2-line" style="font-size: 3rem;"></i>
                                <p class="mt-2">No messages yet. Start the conversation by replying to this ticket.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Reply Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reply to Ticket</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.support.tickets.add-comment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="support_id" value="{{ $support->id }}">
                            
                            <div class="mb-3">
                                <label for="replyMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="replyMessage" name="body" rows="4" placeholder="Type your response here..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachments</label>
                                <input type="file" class="form-control" id="attachment" name="attachments[]" multiple>
                                <div class="form-text">You can attach multiple files (images, documents, etc.)</div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-send-boostere-fill me-1"></i>Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Ticket Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ticket Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Subject</label>
                            <p class="mb-0">{{ $support->subject ?? 'No Subject' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <p class="mb-0">{{ $support->description ?? 'No description provided' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Priority</label>
                            <div>
                                @if($support->priority)
                                    <span class="badge bg-{{ $support->priority === 'high' ? 'danger' : ($support->priority === 'medium' ? 'warning' : 'info') }}">{{ ucfirst($support->priority) }}</span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <span class="badge bg-{{ $support->status === 'open' ? 'success' : ($support->status === 'in_progress' ? 'warning' : ($support->status === 'resolved' ? 'info' : 'secondary')) }}">{{ ucfirst(str_replace('_', ' ', $support->status)) }}</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <p class="mb-0">{{ $support->category ?? 'General' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created</label>
                            <p class="mb-0">{{ $support->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="mb-0">{{ $support->updated_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        
                        
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $support->user->profile_photo_url ?? 'https://randomuser.me/api/portraits/men/32.jpg' }}" alt="Customer" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h6 class="mb-0">{{ $support->user->name ?? 'Unknown User' }}</h6>
                                <small class="text-muted">Customer</small>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Email:</strong> {{ $support->user->email ?? 'No email' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Phone:</strong> {{ $support->user->phone ?? 'No phone' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Location:</strong> {{ $support->user->country->name ?? 'Unknown' }}{{ $support->user->state ? ', ' . $support->user->state->name : '' }}{{ $support->user->city ? ', ' . $support->user->city->name : '' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Member Since:</strong> {{ $support->user->created_at->format('F Y') ?? 'Unknown' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Previous Tickets:</strong> {{ $support->user->supports->count() - 1 ?? 0 }} tickets
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="ri-user-line me-1"></i>View Profile
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="ri-history-line me-1"></i>Ticket History
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#escalateModal">
                                <i class="ri-arrow-up-line me-2"></i>Escalate Ticket
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Escalate Modal -->
<div class="modal fade" id="escalateModal" tabindex="-1" aria-labelledby="escalateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="escalateModalLabel">Escalate Ticket</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="escalateTo" class="form-label">Escalate to</label>
                        <select class="form-select" id="escalateTo" required>
                            <option value="">Select a team member...</option>
                            <option value="1">David Chen - Senior Support</option>
                            <option value="2">Alex Martinez - Technical Lead</option>
                            <option value="3">Lisa Brown - Payment Specialist</option>
                            <option value="4">Mike Wilson - System Admin</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="escalationReason" class="form-label">Reason for escalation</label>
                        <select class="form-select" id="escalationReason" required>
                            <option value="">Select a reason...</option>
                            <option value="technical">Technical issue requiring expertise</option>
                            <option value="payment">Payment processing problem</option>
                            <option value="broadcast">Broadcast customer request</option>
                            <option value="complex">Complex issue beyond current scope</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="escalationNote" class="form-label">Additional notes</label>
                        <textarea class="form-control" id="escalationNote" rows="3" placeholder="Provide context for the escalation..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Escalate Ticket</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Change Ticket Status</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="newStatus" class="form-label">New Status</label>
                        <select class="form-select" id="newStatus" required>
                            <option value="">Select status...</option>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="waiting">Waiting for Customer</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="statusNote" class="form-label">Status change note</label>
                        <textarea class="form-control" id="statusNote" rows="3" placeholder="Optional note about the status change..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Update Status</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
<style>
.card-body {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 #f8f9fa;
}

.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #f8f9fa;
}

.card-body::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #adb5bd;
}

.attachment-preview {
    max-width: 300px;
}

.badge {
    font-size: 0.75rem;
}

.stat {
    font-size: 1.5rem;
}
</style>
@endpush

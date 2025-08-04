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
                            <h5 class="card-title mb-0">Payment Issue - Transaction Failed</h5>
                            <p class="text-muted mb-0">Created by John Smith • 2024-01-15 09:30</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-danger fs-6">High Priority</span>
                            <span class="badge bg-warning fs-6">In Progress</span>
                            
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
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-success" href="#">
                                        <i class="ri-check-line me-2"></i>Mark as Resolved
                                    </a></li>
                                    <li><a class="dropdown-item text-danger" href="#">
                                        <i class="ri-delete-bin-line me-2"></i>Close Ticket
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
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            <div>
                                <div class="fw-bold">John Smith</div>
                                <div class="text-muted small">john.smith@email.com</div>
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
                        <h1 class="mt-1 mb-3">8</h1>
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
                        <!-- Message 1 - Customer -->
                        <div class="d-flex mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 me-2">John Smith</h6>
                                    <small class="text-muted">2024-01-15 09:30</small>
                                    <span class="badge bg-secondary ms-2">Customer</span>
                                </div>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-0">Hi, I'm having trouble completing a payment for a task I finished. The transaction keeps failing and I'm not sure what's wrong. Can you help me resolve this issue?</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message 2 - Admin -->
                        <div class="d-flex mb-4 justify-content-end">
                            <div class="flex-grow-1 text-end">
                                <div class="d-flex align-items-center justify-content-end mb-2">
                                    <span class="badge bg-primary me-2">Support Team</span>
                                    <small class="text-muted me-2">2024-01-15 10:15</small>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                </div>
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <p class="mb-0">Hello John, I'm sorry to hear you're experiencing payment issues. I'll help you resolve this. Can you please provide me with the following information:</p>
                                        <ul class="mb-0 mt-2">
                                            <li>Task ID or reference number</li>
                                            <li>Payment method you're trying to use</li>
                                            <li>Any error messages you're seeing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="rounded-circle ms-3" style="width: 40px; height: 40px;">
                        </div>

                        <!-- Message 3 - Customer -->
                        <div class="d-flex mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 me-2">John Smith</h6>
                                    <small class="text-muted">2024-01-15 11:45</small>
                                    <span class="badge bg-secondary ms-2">Customer</span>
                                </div>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-0">Thanks for the quick response! Here are the details:</p>
                                        <ul class="mb-2">
                                            <li>Task ID: TASK-2024-001</li>
                                            <li>Payment method: Credit card (Visa ending in 1234)</li>
                                            <li>Error message: "Transaction declined. Please try again."</li>
                                        </ul>
                                        <p class="mb-0">I've tried multiple times but keep getting the same error. This is quite urgent as I need to complete the payment to receive my earnings.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message 4 - Admin -->
                        <div class="d-flex mb-4 justify-content-end">
                            <div class="flex-grow-1 text-end">
                                <div class="d-flex align-items-center justify-content-end mb-2">
                                    <span class="badge bg-primary me-2">Support Team</span>
                                    <small class="text-muted me-2">2024-01-15 12:30</small>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                </div>
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <p class="mb-0">Thank you for providing those details, John. I can see the issue now. There seems to be a temporary problem with our payment processor. Let me escalate this to our technical team to resolve it quickly.</p>
                                        <p class="mb-0 mt-2">In the meantime, you can try using an alternative payment method like PayPal or bank transfer. Would you like me to guide you through that process?</p>
                                    </div>
                                </div>
                            </div>
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="rounded-circle ms-3" style="width: 40px; height: 40px;">
                        </div>

                        <!-- Message 5 - Customer with Attachment -->
                        <div class="d-flex mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 me-2">John Smith</h6>
                                    <small class="text-muted">2024-01-15 14:22</small>
                                    <span class="badge bg-secondary ms-2">Customer</span>
                                </div>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-2">I've attached a screenshot of the error message I'm seeing. Also, I tried PayPal but got the same error. This is really affecting my work schedule.</p>
                                        <div class="attachment-preview">
                                            <div class="d-flex align-items-center p-2 bg-white rounded border">
                                                <i class="ri-image-line text-primary me-2"></i>
                                                <span class="flex-grow-1">error_screenshot.png</span>
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reply Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reply to Ticket</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="replyMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="replyMessage" rows="4" placeholder="Type your response here..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachments</label>
                                <input type="file" class="form-control" id="attachment" multiple>
                                <div class="form-text">You can attach multiple files (images, documents, etc.)</div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="internalNote">
                                    <label class="form-check-label" for="internalNote">
                                        Internal note (not visible to customer)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary me-2">
                                        <i class="ri-time-line me-1"></i>Save as Draft
                                    </button>
                                    <button type="button" class="btn btn-outline-warning">
                                        <i class="ri-send-plane-line me-1"></i>Send Later
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-send-plane-fill me-1"></i>Send Reply
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
                            <p class="mb-0">Payment Issue - Transaction Failed</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <p class="mb-0">Unable to complete payment for task completion. Customer experiencing transaction failures with multiple payment methods.</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Priority</label>
                            <div>
                                <span class="badge bg-danger">High</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <span class="badge bg-warning">In Progress</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <p class="mb-0">Payment Issues</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created</label>
                            <p class="mb-0">January 15, 2024 at 09:30 AM</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="mb-0">January 16, 2024 at 02:22 PM</p>
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
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h6 class="mb-0">John Smith</h6>
                                <small class="text-muted">Customer</small>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Email:</strong> john.smith@email.com
                        </div>
                        
                        <div class="mb-2">
                            <strong>Phone:</strong> +1 (555) 123-4567
                        </div>
                        
                        <div class="mb-2">
                            <strong>Location:</strong> New York, USA
                        </div>
                        
                        <div class="mb-2">
                            <strong>Member Since:</strong> March 2023
                        </div>
                        
                        <div class="mb-2">
                            <strong>Previous Tickets:</strong> 3 (2 resolved, 1 closed)
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
                            <button class="btn btn-success" data-toggle="modal" data-target="#resolveModal">
                                <i class="ri-check-line me-2"></i>Mark as Resolved
                            </button>
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
                            <option value="urgent">Urgent customer request</option>
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

<!-- Resolve Modal -->
<div class="modal fade" id="resolveModal" tabindex="-1" aria-labelledby="resolveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resolveModalLabel">Mark Ticket as Resolved</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="resolutionType" class="form-label">Resolution Type</label>
                        <select class="form-select" id="resolutionType" required>
                            <option value="">Select resolution type...</option>
                            <option value="solved">Issue Solved</option>
                            <option value="workaround">Workaround Provided</option>
                            <option value="duplicate">Duplicate Ticket</option>
                            <option value="not_reproducible">Cannot Reproduce</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="resolutionNote" class="form-label">Resolution Summary</label>
                        <textarea class="form-control" id="resolutionNote" rows="4" placeholder="Describe how the issue was resolved..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notifyCustomer">
                            <label class="form-check-label" for="notifyCustomer">
                                Notify customer about resolution
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success">Mark as Resolved</button>
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

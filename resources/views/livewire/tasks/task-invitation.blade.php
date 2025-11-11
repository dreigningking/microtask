<div>
    <div wire:ignore class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteModalLabel">Invite Workers to Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Invitation Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-primary mb-1">{{ $totalInvitees }}</h4>
                                <small class="text-muted">Total Invited</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-success mb-1">{{ $accepted_invitees }}</h4>
                                <small class="text-muted">Accepted</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-warning mb-1">{{ $pending_invitees }}</h4>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Invitations -->
                    @if($existingInvitations->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Existing Invitations</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Invited Date</th>
                                            <th>Expires</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($existingInvitations as $invitation)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                        <i class="ri-mail-line text-muted fs-6"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium small">{{ $invitation->email }}</div>
                                                        @if($invitation->invitee)
                                                        <small class="text-muted">{{ $invitation->invitee->username }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($invitation->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                                @elseif($invitation->status === 'invited')
                                                <span class="badge bg-warning">Pending</span>
                                                @else
                                                <span class="badge bg-secondary">{{ ucfirst($invitation->status) }}</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $invitation->created_at->format('M d, Y') }}</small></td>
                                            <td>
                                                @if($invitation->expire_at)
                                                @if($invitation->expire_at->isPast())
                                                <small class="text-danger">Expired</small>
                                                @else
                                                <small>{{ $invitation->expire_at->diffForHumans() }}</small>
                                                @endif
                                                @else
                                                <small class="text-muted">No expiry</small>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Invite New Users -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Invite New Workers</h6>
                        </div>
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form wire:submit="inviteUsers">
                                <div class="mb-3">
                                    <label class="form-label">Email Addresses</label>
                                    <div id="email-fields">
                                        @foreach($emails as $index => $email)
                                        <div class="input-group mb-2 email-field">
                                            <input type="email"
                                                wire:model="emails.{{ $index }}"
                                                class="form-control form-control-sm @error('emails.' . $index) is-invalid @enderror"
                                                placeholder="Enter email address"
                                                value="{{ $email }}">
                                            @if(count($emails) > 1)
                                            <button type="button" wire:click="removeEmailField({{ $index }})" class="btn btn-outline-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                            @endif
                                            @error('emails.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if(!empty($email) && \App\Models\Referral::where('task_id', $task->id)->where('email', $email)->where('expire_at', '>', now())->exists())
                                            <small class="text-warning ms-2">Already invited</small>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" wire:click="addEmailField" class="btn btn-outline-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> Add Another Email
                                    </button>
                                </div>

                                @if($inviteSummary)
                                <div class="alert alert-info mb-3">
                                    {{ $inviteSummary }}
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="inviteUsers" wire:loading.attr="disabled" wire:target="inviteUsers" class="btn btn-primary">
                        <span wire:loading.class="d-none" wire:target="inviteUsers" class="d-inline-flex">
                            <i class="ri-send-plane-line me-1"></i> Send Invitations
                        </span>
                        <span wire:loading.class="d-inline-flex" wire:target="inviteUsers" class="" style="display: none;">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Sending...
                        </span>
                        
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
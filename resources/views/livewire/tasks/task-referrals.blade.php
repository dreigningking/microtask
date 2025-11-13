<div>
    <div wire:ignore.self class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel" aria-hidden="true" wire:ignore.self>
        <div wire:ignore.self class="modal-dialog modal-lg">
            <div wire:ignore.self class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="referralModalLabel">Refer Workers to this task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Invitation Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-primary mb-1">{{ $totalReferrals }}</h4>
                                <small class="text-muted">Total Referred</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-success mb-1">{{ $completed_referrals }}</h4>
                                <small class="text-muted">Completed</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center p-3">
                                <h4 class="text-warning mb-1">{{ $pending_referrals }}</h4>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>

                    </div>

                    <!-- Existing Invitations -->
                    @if($existingReferrals->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Referred Users</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover overflow-y-auto">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Referred Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($existingReferrals as $referral)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $referral->referree->avatar ?? 'https://placehold.co/32' }}" alt="User" class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium small">{{ $referral->referree->username }}</div>
                                                        <small class="text-muted">{{ $referral->referree->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($referral->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                                @elseif($referral->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @else
                                                <span class="badge bg-secondary">{{ ucfirst($referral->status) }}</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $referral->created_at->format('M d, Y') }}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Refer Users -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Refer Users</h6>
                        </div>
                        <div class="card-body">

                            <form wire:submit="referUsers">
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
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            @endif
                                            @error('emails.' . $index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" wire:click="addEmailField" class="btn btn-outline-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> Add Another Email
                                    </button>
                                </div>

                                @if (session()->has('message'))
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="referUsers" wire:loading.attr="disabled" wire:target="referUsers" class="btn btn-primary">
                        <span wire:loading.class="d-none" wire:target="referUsers" class="d-inline-flex">
                            <i class="ri-send-plane-line me-1"></i> Send Referrals
                        </span>
                        <span wire:loading.class="d-inline-flex" wire:target="referUsers" class="" style="display: none;">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Sending...
                        </span>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
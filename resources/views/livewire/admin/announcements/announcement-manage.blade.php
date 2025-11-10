<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Announcement Management</h4>
            <p class="text-muted">Manage platform announcements and user targeting</p>
        </div>
        <button type="button" class="btn btn-primary" wire:click="openCreateModal">
            <i class="fas fa-plus"></i> New Announcement
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Announcements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sent</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sent'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Scheduled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['scheduled'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['this_month'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search announcements..." wire:model.live="search">
                </div>
                <div class="col-md-2">
                    <select class="form-control" wire:model.live="statusFilter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="sent">Sent</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" wire:model.live="priorityFilter">
                        <option value="all">All Priority</option>
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" wire:model.live="dateFrom">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" wire:model.live="dateTo">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-secondary" wire:click="resetFilters">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Announcements</h6>
            <span class="badge badge-primary">{{ $announcements->total() }} total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Target Segment</th>
                            <th>Via</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Recipients</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $announcement)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($announcement->subject, 50) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($announcement->message, 100) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ \App\Models\User::getSegmentName($announcement->target_segment) }}
                                </span>
                            </td>
                            <td>
                                @if($announcement->via === 'both')
                                    <span class="badge badge-secondary">Email & In-App</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($announcement->via) }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $priorityColors = [
                                        'low' => 'success',
                                        'normal' => 'info', 
                                        'high' => 'warning',
                                        'urgent' => 'danger'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $priorityColors[$announcement->priority] }}">
                                    {{ ucfirst($announcement->priority) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'sent' => 'success',
                                        'scheduled' => 'info',
                                        'failed' => 'danger'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $statusColors[$announcement->status] }}">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                                @if($announcement->scheduled_at && $announcement->status === 'scheduled')
                                    <br><small class="text-muted">For {{ $announcement->scheduled_at->format('M d, Y \a\t h:i A') }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $announcement->recipients_count }}</strong>
                                @if($announcement->recipients_count > 0)
                                    <br>
                                    <small class="text-muted">
                                        {{ $announcement->open_rate }}% open rate
                                    </small>
                                @endif
                            </td>
                            <td>
                                {{ $announcement->created_at->format('M d, Y') }}
                                <br>
                                <small class="text-muted">by {{ $announcement->sender->name ?? 'Unknown' }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info" 
                                            wire:click="openViewModal({{ $announcement->id }})"
                                            title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($announcement->status !== 'sent')
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                wire:click="openEditModal({{ $announcement->id }})"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                    @if($announcement->status === 'scheduled')
                                        <button type="button" class="btn btn-sm btn-success" 
                                                wire:click="sendNow({{ $announcement->id }})"
                                                title="Send Now">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    @endif
                                    @if($announcement->is_archived)
                                        <button type="button" class="btn btn-sm btn-secondary" 
                                                wire:click="unarchive({{ $announcement->id }})"
                                                title="Unarchive">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-secondary" 
                                                wire:click="archive({{ $announcement->id }})"
                                                title="Archive">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            wire:click="delete({{ $announcement->id }})"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="fas fa-bullhorn fa-2x mb-2"></i>
                                <br>No announcements found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>

    <!-- Modals would be included here -->
    <!-- Create Modal, Edit Modal, View Modal components would be rendered here -->
</div>

@script
<script>
    // JavaScript for handling modal events and alerts
    document.addEventListener('livewire:initialized', () => {
        // Listen for custom events
        Livewire.on('showAlert', (data) => {
            // Show success/error alert
            if (data.type === 'success') {
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
        });

        Livewire.on('announcementUpdated', () => {
            // Refresh data or show success message
            toastr.success('Announcement updated successfully');
        });

        Livewire.on('modalOpened', () => {
            // Initialize modal functionality
            console.log('Modal opened');
        });
    });
</script>
@endscript
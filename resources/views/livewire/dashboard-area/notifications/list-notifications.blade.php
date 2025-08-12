<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 mb-2">Notifications</h1>
                    <p class="text-muted mb-0">Manage and view all your notifications</p>
                </div>
                <div class="d-flex gap-2">
                    <button wire:click="markAllAsRead" class="btn btn-outline-primary">
                        <i class="fa fa-check-double me-1"></i>
                        Mark All as Read
                    </button>
                    <button wire:click="clearAllRead" class="btn btn-outline-danger" 
                            onclick="return confirm('Are you sure you want to clear all read notifications?')">
                        <i class="fa fa-trash me-1"></i>
                        Clear Read
                    </button>
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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Total Notifications</h6>
                            <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa fa-bell text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Unread</h6>
                            <h3 class="mb-0">{{ number_format($stats['unread']) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa fa-envelope text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Read</h6>
                            <h3 class="mb-0">{{ number_format($stats['read']) }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa fa-check-circle text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search Notifications</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="form-control" 
                               id="search" 
                               placeholder="Search by title, message, or subject...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="filter" class="form-label">Filter by Status</label>
                    <select wire:model.live="filter" class="form-select" id="filter">
                        <option value="all">All Notifications</option>
                        <option value="unread">Unread Only</option>
                        <option value="read">Read Only</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="perPage" class="form-label">Per Page</label>
                    <select wire:model.live="perPage" class="form-select" id="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-list me-2 text-primary"></i>
                Notifications ({{ $notifications->total() }})
            </h5>
        </div>
        <div class="card-body p-0">
            @forelse($notifications as $notification)
            <div class="notification-item p-3 border-bottom {{ $loop->last ? 'border-bottom-0' : '' }} {{ $notification->read_at ? 'bg-light' : 'bg-white' }}">
                <div class="d-flex gap-3">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0">
                        <div class="notification-icon rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background-color: {{ $notification->read_at ? '#e9ecef' : '#007bff' }};">
                            @if(isset($notification->data['icon']))
                                <i class="{{ $notification->data['icon'] }} {{ $notification->read_at ? 'text-muted' : 'text-white' }}"></i>
                            @else
                                <i class="fa fa-bell {{ $notification->read_at ? 'text-muted' : 'text-white' }}"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Notification Content -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}">
                                    {{ $notification->data['title'] ?? $notification->data['subject'] ?? 'Notification' }}
                                </h6>
                                <p class="mb-1 text-muted small">
                                    {{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message content' }}
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                @if(!$notification->read_at)
                                <button wire:click="markAsRead('{{ $notification->id }}')" 
                                        class="btn btn-sm btn-outline-success" 
                                        title="Mark as read">
                                    <i class="fa fa-check"></i>
                                </button>
                                @endif
                                <button wire:click="deleteNotification('{{ $notification->id }}')" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Are you sure you want to delete this notification?')"
                                        title="Delete notification">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Notification Metadata -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-3">
                                @if(isset($notification->data['type']))
                                <span class="badge bg-secondary">{{ ucfirst($notification->data['type']) }}</span>
                                @endif
                                @if(isset($notification->data['priority']))
                                <span class="badge bg-{{ $notification->data['priority'] === 'high' ? 'danger' : ($notification->data['priority'] === 'medium' ? 'warning' : 'info') }}">
                                    {{ ucfirst($notification->data['priority']) }} Priority
                                </span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="fa fa-clock-o me-1"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <!-- Action Links -->
                        @if(isset($notification->data['action_url']))
                        <div class="mt-2">
                            <a href="{{ $notification->data['action_url'] }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-external-link me-1"></i>
                                {{ $notification->data['action_text'] ?? 'View Details' }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fa fa-bell-slash text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted mb-2">No notifications found</h5>
                <p class="text-muted mb-0">
                    @if(!empty($search) || $filter !== 'all')
                        Try adjusting your search criteria or filters.
                    @else
                        You're all caught up! No notifications to display.
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} 
                    of {{ $notifications->total() }} notifications
                </div>
                <div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

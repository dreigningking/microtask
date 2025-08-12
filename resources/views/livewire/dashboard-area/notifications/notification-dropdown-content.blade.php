<div>
@forelse($recentNotifications as $notification)
<div class="dropdown-item preview-item {{ $notification->read_at ? 'opacity-75' : '' }}">
    <div class="preview-thumbnail">
        <div class="preview-icon {{ $notification->read_at ? 'bg-secondary' : 'bg-primary' }}">
            @if(isset($notification->data['icon']))
                <i class="{{ $notification->data['icon'] }} mx-0"></i>
            @else
                <i class="ti-info-alt mx-0"></i>
            @endif
        </div>
    </div>
    <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal {{ $notification->read_at ? 'text-muted' : '' }}">
            {{ $notification->data['title'] ?? $notification->data['subject'] ?? 'Notification' }}
        </h6>
        <p class="font-weight-light small-text mb-0 text-muted">
            {{ $notification->created_at->diffForHumans() }}
        </p>
        @if(isset($notification->data['action_url']) && !$notification->read_at)
        <div class="mt-2">
            <button wire:click="markAsRead('{{ $notification->id }}')" 
                    class="btn btn-sm btn-outline-primary btn-sm">
                <i class="ti-check me-1"></i> Mark as Read
            </button>
        </div>
        @endif
    </div>
</div>
@empty
<div class="dropdown-item preview-item text-center py-3">
    <div class="text-muted">
        
        <p class="mb-0 small">No notifications</p>
    </div>
</div>
@endforelse

@if(count($recentNotifications) > 0)
<div class="dropdown-divider"></div>
<div class="dropdown-item text-center">
    <a href="{{ route('notifications') }}" class="text-decoration-none">
        <small class="text-muted">View all notifications</small>
    </a>
</div>
@endif
</div>
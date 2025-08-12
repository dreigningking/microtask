<div>
@if($unreadCount > 0)
<span class="count">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
@endif
</div>
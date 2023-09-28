

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if($newCount)
        <span class="badge badge-warning navbar-badge">{{ $newCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $newCount }} Notifications</span>
        <div class="dropdown-divider"></div>
        @foreach ($notifications as $notification )
            
      
        <a href="{{ route('dashboard') }}?notification_id={{ $notification->id }}" class="dropdown-item @if($notification->unread()) text-bold @endif">
            <i class="fas fa-file mr-2"></i> {{ $notification->data['body'] }}
            <span class="float-right text-muted text-sm">{{ $notification->created_at->shortAbsoluteDiffForHumans() }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="{{ route('notification.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
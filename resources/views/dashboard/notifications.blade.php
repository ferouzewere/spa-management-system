<div class="card">
    <div class="card-header bg-info text-white">
        <div class="d-flex justify-content-between align-items-center">
            <span>Notifications</span>
            <button class="btn btn-sm btn-light" id="markAllRead">Mark All as Read</button>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            @forelse(Auth::user()->notifications()->latest()->get() as $notification)
            <div class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'bg-light' }}">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>
            </div>
            @empty
            <p class="text-muted text-center my-3">No notifications to display</p>
            @endforelse
        </div>
    </div>
</div>
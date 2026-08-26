@extends('cashier.layout')
@section('title', 'Notifications | MarketSmart')
@section('page_title', 'Notifications')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Notifications</h3>
        <form method="POST" action="{{ route('cashier.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-light btn-sm">
                Mark all as read
            </button>
        </form>
    </div>
    <div class="card-body">
        @forelse($notifications as $notification)
        @if(!$notification->is_read)
                        <form method="POST" action="{{ route('cashier.notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm">
                                Read
                            </button>
                        </form>
                    @endif
            <div class="notification {{ !$notification->is_read ? 'unread' : '' }} mb-3 p-3 border rounded">
                <div class="d-flex">
                    <div class="notification-icon me-3">
                        {{ $notification->type === 'payment' ? '💰' : '⚠️' }}
                    </div>
                    <div style="flex:1">
                        <strong>{{ $notification->title }}</strong>
                        <p class="muted mb-1">{{ $notification->message }}</p>
                        <small class="muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    
                </div>
            </div>
        @empty
            <div class="empty-state text-center text-muted py-4">
                No notifications.
            </div>
        @endforelse
    </div>
</div>
@endsection
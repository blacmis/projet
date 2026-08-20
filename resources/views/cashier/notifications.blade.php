@extends('cashier.layout')
@section('title','Notifications | MarketSmart')
@section('page_title','Notifications')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Notifications</h3>
        <form method="POST" action="{{ route('cashier.notifications.read-all') }}">
            @csrf
            <button class="btn btn-light">Mark all as read        <form method="POST" action="{{ route('cashier.notifications.read-all') }}">
</button>
        </form>
    </div>

    @forelse($notifications as $notification)
        <div class="notification {{ !$notification->is_read ? 'unread' : '' }}">
            <div class="notification-icon">
                {{ $notification->type === 'payment' ? '₣' : '!' }}
            </div>
            <div style="flex:1">
                <strong>{{ $notification->title }}</strong>
                <p class="muted">{{ $notification->message }}</p>
                <small class="muted">{{ $notification->created_at->diffForHumans() }}</small>
            </div>
            @if(!$notification->is_read)
                <form method="POST" action="{{ route('cashier.notifications.read', $notification) }}">
                    @csrf
                    <button class="btn btn-light">Read</button>
                </form>
            @endif
        </div>
    @empty
        <div class="empty-state">No notifications.</div>
    @endforelse

    <div class="pagination">{{ $notifications->links() }}</div>
</div>
@endsection

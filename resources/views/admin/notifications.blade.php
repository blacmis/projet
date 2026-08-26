@extends('admin.layouts.app')

@section('title', 'Notifications | MarketSmart Admin')

@section('content')
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">🔔 Notifications</h5>

        <form method="POST" action="{{ route('admin.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">
                Mark all as read
            </button>
        </form>
    </div>

    @forelse($notifications as $n)
        <div class="d-flex align-items-start gap-3 p-3 mb-2 border rounded"
             style="{{ !$n->is_read ? 'background:#fff8f0;' : 'background:#fff;' }}">
            <div style="font-size:1.5rem;line-height:1;">
                @if($n->type === 'warning') ⚠️
                @elseif($n->type === 'expiry') ⏰
                @elseif($n->type === 'danger') 🚨
                @else ℹ️
                @endif
            </div>
            <div style="flex:1;">
                <strong>{{ $n->title }}</strong>
                <p class="mb-1 text-muted">{{ $n->message }}</p>
                <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
            </div>
            @if(!$n->is_read)
                <span class="badge-status badge-low">New</span>
            @endif
        </div>
    @empty
        <p class="text-muted text-center py-4">No notifications.</p>
    @endforelse
</div>
@endsection
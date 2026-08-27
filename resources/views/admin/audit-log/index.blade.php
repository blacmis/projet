@extends('admin.layouts.app')
@section('title', 'Audit Log | MarketSmart Admin')
@section('content')
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">📜 Admin Audit Log</h5>
        <form method="POST" action="{{ route('admin.audit-log.clear') }}"
              onsubmit="return confirm('Vider tout le journal ?')">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Clear log</button>
        </form>
    </div>
    <form method="GET" class="mb-3">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
               placeholder="Search action, user, details..." style="max-width:280px;">
    </form>
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date / Time</th>
                    <th>Admin</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $log['at'] }}</td>
                    <td>{{ $log['user'] }}</td>
                    <td><strong>{{ $log['action'] }}</strong></td>
                    <td>{{ $log['details'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Aucune action enregistrée pour le moment.
                        Effectue un Cancel vente, un ajustement stock ou un toggle user.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
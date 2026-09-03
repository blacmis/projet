@extends('admin.layouts.app')
@section('title', 'Users | MarketSmart Admin')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->total }}</p>
            <p class="stat-label">Total Users</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->active }}</p>
            <p class="stat-label">Active</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->managers }}</p>
            <p class="stat-label">Managers</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="stat-value">{{ $stats->cashiers }}</p>
            <p class="stat-label">Cashiers</p>
        </div>
    </div>
</div>
<div class="admin-table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">👥 User Management</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm" style="background:#c47a1a;color:#fff;">
            + Add User
        </a>
    </div>
    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2 flex-wrap mb-3">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
               placeholder="Search name or email" style="max-width:200px;">
        <select name="role" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All roles</option>
            <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            <option value="manager" {{ request('role')=='manager'?'selected':'' }}>Manager</option>
            <option value="cashier" {{ request('role')=='cashier'?'selected':'' }}>Cashier</option>
        </select>
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All status</option>
            <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u['id'] }}</td>
                    <td>{{ $u['name'] }}</td>
                    <td>{{ $u['email'] }}</td>
                    <td>
                        <span class="badge-status {{ $u['role']==='admin' ? 'badge-low' : ($u['role']==='manager' ? 'badge-good' : 'badge-done') }}">
                            {{ ucfirst($u['role']) }}
                        </span>
                    </td>
                    <td>
                        @if($u['status'] === 'active')
                            <span class="badge-status badge-good">Active</span>
                        @else
                            <span class="badge-status badge-out">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $u['created_at'] }}</td>
                    <td class="text-nowrap">
                        <form action="{{ route('admin.users.toggle', $u['id']) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                    title="{{ $u['status']==='active' ? 'Désactiver' : 'Activer' }}">
                                {{ $u['status']==='active' ? '🔒' : '🔓' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.unlock', $u['id']) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Déverrouiller login">
                                🔓 Unlock
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $u['id']) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun utilisateur</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
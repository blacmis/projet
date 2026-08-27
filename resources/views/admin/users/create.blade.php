@extends('admin.layouts.app')
@section('title', 'Add User | MarketSmart Admin')
@section('content')
<div class="admin-table-wrap" style="max-width:560px;">
    <h5 class="mb-3">+ Create User</h5>
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2">
            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="manager" {{ old('role')=='manager'?'selected':'' }}>Manager</option>
                <option value="cashier" {{ old('role')=='cashier'?'selected':'' }}>Cashier</option>
                <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (mock)</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn" style="background:#c47a1a;color:#fff;">Save User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
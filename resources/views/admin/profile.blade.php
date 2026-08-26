@extends('admin.layouts.app')

@section('title', 'Profile | MarketSmart Admin')

@section('content')
<h4 class="mb-4">Administrator Profile</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="row align-items-start">
            {{-- Avatar --}}
            <div class="col-md-3 text-center mb-3 mb-md-0">
                <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:120px;height:120px;border-radius:12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#adb5bd" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg>
                </div>
                <button type="button" class="btn btn-sm" style="background:#c47a1a;color:#fff;border:none;">
                    Change Photo
                </button>
            </div>

            {{-- Infos --}}
            <div class="col-md-9">
                <h5 class="mb-3">My Profile</h5>

                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Full Name:</div>
                    <div class="col-sm-8 fw-semibold">{{ $user->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Email:</div>
                    <div class="col-sm-8">{{ $user->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Phone:</div>
                    <div class="col-sm-8">{{ $user->phone }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Role:</div>
                    <div class="col-sm-8">{{ $user->role }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Department:</div>
                    <div class="col-sm-8">{{ $user->department }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Joined:</div>
                    <div class="col-sm-8">{{ $user->joined }}</div>
                </div>

                <button type="button" class="btn btn-outline-secondary btn-sm"
                        data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    Edit Profile
                </button>
            </div>
        </div>

        <hr class="my-4">

        {{-- Stats --}}
        <div class="row text-center">
            <div class="col-md-4">
                <h3 style="color:#c47a1a;">{{ $user->login_count }}</h3>
                <p class="text-muted mb-0">Login Count</p>
            </div>
            <div class="col-md-4">
                <h3 class="text-success">{{ $user->account_status }}</h3>
                <p class="text-muted mb-0">Account Status</p>
            </div>
            <div class="col-md-4">
                <h3>{{ $user->security_level }}</h3>
                <p class="text-muted mb-0">Security Level</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background:#c47a1a;color:#fff;border:none;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
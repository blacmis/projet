@extends('manager.layouts.app')
@section('page_title', 'My Profile')
@section('content')
    <div class="page-header">
        <h4 class="page-title"> Inventory Manager Profile</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Photo de profil --}}
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto"
                             style="width: 140px; height: 140px;">
                            <i class="bi bi-person-fill" style="font-size: 4rem; color: #adb5bd;"></i>
                        </div>
                    </div>
                    <button class="btn btn-orange btn-sm">
                        <i class="bi bi-camera"></i> Change Photo
                    </button>
                </div>
                {{-- Informations --}}
                <div class="col-md-9">
                    <h5 class="mb-4">My Profile</h5>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Full Name:</div>
                        <div class="col-sm-8 fw-semibold">Inventory Manager</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Email:</div>
                        <div class="col-sm-8">inventory.manager@marketsmart.com</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Phone:</div>
                        <div class="col-sm-8">677 000 000</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Role:</div>
                        <div class="col-sm-8">Inventory Manager</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Department:</div>
                        <div class="col-sm-8">Inventory Department</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Joined:</div>
                        <div class="col-sm-8">01/03/2026</div>
                    </div>
                    <button class="btn btn-outline-orange">
                        <i class="bi bi-pencil"></i> Edit Profile
                    </button>
                </div>
            </div>
            {{-- Stats en bas --}}
            <hr class="my-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="stat-card text-center">
                        <h5 class="mb-1">124</h5>
                        <small class="text-muted">Login Count</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center">
                        <h5 class="mb-1 text-success">Verified</h5>
                        <small class="text-muted">Account Status</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card text-center">
                        <h5 class="mb-1">High</h5>
                        <small class="text-muted">Security Level</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i> User Details
                    </h5>
                    <div>
                        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <span class="text-white display-4">{{ strtoupper(substr($user->full_name, 0, 1)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">User ID:</div>
                        <div class="col-md-8">{{ $user->user_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Full Name:</div>
                        <div class="col-md-8">{{ $user->full_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Username:</div>
                        <div class="col-md-8">{{ $user->username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phone:</div>
                        <div class="col-md-8">{{ $user->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Role:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $user->role->role_name == 'admin' ? 'danger' : ($user->role->role_name == 'teacher' ? 'primary' : 'success') }} px-3 py-2">
                                {{ ucfirst($user->role->role_name ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">{{ $user->status ?? 'Active' }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Member Since:</div>
                        <div class="col-md-8">{{ $user->created_at->format('F d, Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('F d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

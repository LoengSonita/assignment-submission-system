@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Role Details
                    </h5>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-light btn-sm">Back</a>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Role ID:</div>
                        <div class="col-md-9">{{ $role->role_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Role Name:</div>
                        <div class="col-md-9">
                            @php
                                $badgeClass = match($role->role_name) {
                                    'admin' => 'danger',
                                    'teacher' => 'primary',
                                    default => 'success'
                                };
                                $roleIcon = match($role->role_name) {
                                    'admin' => 'fa-crown',
                                    'teacher' => 'fa-chalkboard-user',
                                    default => 'fa-user-graduate'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                                <i class="fas {{ $roleIcon }} me-1"></i>
                                {{ ucfirst($role->role_name) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Users Count:</div>
                        <div class="col-md-9">{{ $role->users_count ?? $role->users()->count() }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created At:</div>
                        <div class="col-md-9">{{ $role->created_at ? $role->created_at->format('M d, Y H:i') : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Last Updated:</div>
                        <div class="col-md-9">{{ $role->updated_at ? $role->updated_at->format('M d, Y H:i') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

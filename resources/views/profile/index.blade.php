@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body text-center p-4">
                    <div class="position-relative d-inline-block mb-3">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <span class="text-white display-4">{{ strtoupper(substr($user->full_name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0"
                                data-bs-toggle="modal" data-bs-target="#avatarModal" style="width: 32px; height: 32px;">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <h4 class="fw-bold mb-1">{{ $user->full_name }}</h4>
                    <p class="text-muted mb-2">
                        @php
                            $role = $user->role->role_name ?? 'user';
                        @endphp
                        <span class="badge role-badge {{ $role }} px-3 py-2">
                            <i class="fas
                                @if($role == 'admin') fa-crown
                                @elseif($role == 'teacher') fa-chalkboard-user
                                @else fa-user-graduate
                                @endif me-1"></i>
                            {{ ucfirst($role) }}
                        </span>
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-calendar-alt me-1"></i> Member since {{ $user->created_at->format('F Y') }}
                    </p>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-simple me-2 text-primary"></i> Quick Stats
                    </h5>
                </div>
                <div class="card-body p-4 pt-0">
                    @if($user->role_id == 3) {{-- Student --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Submissions</span>
                                <span class="fw-bold">{{ $stats['total_submissions'] ?? 0 }}</span>
                            </div>
                            <div class="progress bg-light rounded-pill" style="height: 8px;">
                                <div class="progress-bar-custom" style="width: {{ min(100, (($stats['total_submissions'] ?? 0) / 20) * 100) }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Pending Grades</span>
                                <span class="fw-bold text-warning">{{ $stats['pending_grades'] ?? 0 }}</span>
                            </div>
                            <div class="progress bg-light rounded-pill" style="height: 8px;">
                                <div class="progress-bar-custom" style="width: {{ ($stats['pending_grades'] ?? 0) > 0 ? (($stats['pending_grades'] ?? 0) / max(1, ($stats['total_submissions'] ?? 1))) * 100 : 0 }}%; background: #ffc107;"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Average Grade</span>
                                <span class="fw-bold text-success">{{ round($stats['average_grade'] ?? 0) }}%</span>
                            </div>
                            <div class="progress bg-light rounded-pill" style="height: 8px;">
                                <div class="progress-bar-custom" style="width: {{ $stats['average_grade'] ?? 0 }}%; background: #28a745;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Enrolled Courses</span>
                                <span class="fw-bold text-info">{{ $stats['enrolled_courses'] ?? 0 }}</span>
                            </div>
                            <div class="progress bg-light rounded-pill" style="height: 8px;">
                                <div class="progress-bar-custom" style="width: {{ min(100, (($stats['enrolled_courses'] ?? 0) / 10) * 100) }}%; background: #17a2b8;"></div>
                            </div>
                        </div>
                    @elseif($user->role_id == 2) {{-- Teacher --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Courses Created</span>
                                <span class="fw-bold">{{ $stats['total_courses'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Assignments Created</span>
                                <span class="fw-bold">{{ $stats['total_assignments'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Submissions</span>
                                <span class="fw-bold">{{ $stats['total_submissions'] ?? 0 }}</span>
                            </div>
                        </div>
                    @else {{-- Admin --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Users</span>
                                <span class="fw-bold">{{ $stats['total_users'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Courses</span>
                                <span class="fw-bold">{{ $stats['total_courses'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Assignments</span>
                                <span class="fw-bold">{{ $stats['total_assignments'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Submissions</span>
                                <span class="fw-bold">{{ $stats['total_submissions'] ?? 0 }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Update Profile Form -->
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i> Edit Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <div><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i> Change Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-lock me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Upload Profile Picture</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                    </div>
                    <input type="file" name="avatar" class="form-control" accept="image/*" required>
                    <small class="text-muted">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .role-badge.admin { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .role-badge.teacher { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .role-badge.student { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
    .progress-bar-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; }
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
</style>
@endsection

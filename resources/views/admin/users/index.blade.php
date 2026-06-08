@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-users-cog me-2"></i> User Management
                            </h2>
                            <p class="mb-0 opacity-90">Manage system users, assign roles, and control access permissions.</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h2 class="fw-bold mb-0 text-primary">{{ $users->total() }}</h2>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Students</h6>
                            <h2 class="fw-bold mb-0 text-success">{{ $totalStudents ?? 0 }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Teachers</h6>
                            <h2 class="fw-bold mb-0 text-info">{{ $totalTeachers ?? 0 }}</h2>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-chalkboard-user fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Admins</h6>
                            <h2 class="fw-bold mb-0 text-warning">{{ $totalAdmins ?? 0 }}</h2>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-crown fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> User List</h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <input type="text" id="searchInput" class="form-control rounded-3" placeholder="Search users...">
                    <button class="btn btn-outline-primary rounded-3" onclick="searchUsers()"><i class="fas fa-search"></i></button>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-3">
                    <i class="fas fa-plus me-1"></i> Add User
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>ID</th><th>User</th><th>Contact</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="fw-bold">{{ $user->user_id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">{{ strtoupper(substr($user->full_name, 0, 1)) }}</div>
                                    <div><div class="fw-bold">{{ $user->full_name }}</div><div class="text-muted small">@ {{ $user->username }}</div></div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope text-muted me-1"></i> {{ $user->email }}</div>
                                @if($user->phone)<div class="text-muted small"><i class="fas fa-phone me-1"></i> {{ $user->phone }}</div>@endif
                            </td>
                            <td>
                                @php
                                    $roleName = $user->role->role_name ?? 'user';
                                    $roleClass = match($roleName) { 'admin' => 'danger', 'teacher' => 'primary', default => 'success' };
                                @endphp
                                <span class="badge bg-{{ $roleClass }} bg-opacity-10 text-{{ $roleClass }} px-3 py-2">
                                    <i class="fas fa-{{ $roleName == 'admin' ? 'crown' : ($roleName == 'teacher' ? 'chalkboard-user' : 'user-graduate') }} me-1"></i> {{ ucfirst($roleName) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $user->status == 'active' ? 'check-circle' : 'ban' }} me-1"></i> {{ ucfirst($user->status ?? 'Active') }}
                                </span>
                            </td>
                            <td><i class="fas fa-calendar-alt text-muted me-1"></i> {{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.show', $user->user_id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                    @if($user->user_id != Auth::user()->user_id)
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $user->user_id }}, '{{ $user->full_name }}')"><i class="fas fa-trash"></i></button>
                                        <form id="delete-form-{{ $user->user_id }}" action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" style="display: none;">@csrf @method('DELETE')</form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5"><i class="fas fa-users fa-3x text-muted mb-3"></i><h5 class="text-muted">No users found</h5><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) { if(confirm(`Delete user "${name}"?`)) document.getElementById('delete-form-'+id).submit(); }
    function searchUsers() { let filter = document.getElementById('searchInput').value.toLowerCase(); let rows = document.querySelectorAll('.table tbody tr'); rows.forEach(row => { let text = row.innerText.toLowerCase(); row.style.display = text.includes(filter) ? '' : 'none'; }); }
    document.getElementById('searchInput')?.addEventListener('keyup', e => { if(e.key === 'Enter') searchUsers(); });
</script>
<style>
    .avatar-circle { width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px; }
    .hover-card { transition: transform 0.3s ease; } .hover-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
</style>
@endsection

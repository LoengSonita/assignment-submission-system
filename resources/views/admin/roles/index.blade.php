@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i> Role Management
                    </h5>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Add New Role
                    </a>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                    <th>Users Count</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->role_id }}</td>
                                    <td>
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
                                    </td>
                                    <td>{{ $role->users_count ?? 0 }}</td>
                                    <td>{{ $role->created_at ? $role->created_at->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.roles.show', $role->role_id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.roles.edit', $role->role_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(!in_array($role->role_name, ['admin', 'teacher', 'student']))
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="confirmDelete({{ $role->role_id }}, '{{ $role->role_name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $role->role_id }}"
                                                      action="{{ route('admin.roles.destroy', $role->role_id) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-key fa-2x mb-2 d-block"></i>
                                        No roles found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        if (confirm('Are you sure you want to delete role "' + name + '"?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.3s ease;
    }
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 8px;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Role
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.update', $role->role_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="role_name" class="form-label fw-bold">
                                <i class="fas fa-tag me-1 text-primary"></i> Role Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="role_name" id="role_name"
                                   class="form-control @error('role_name') is-invalid @enderror"
                                   value="{{ old('role_name', $role->role_name) }}"
                                   {{ in_array($role->role_name, ['admin', 'teacher', 'student']) ? 'disabled' : '' }}
                                   required>
                            @if(in_array($role->role_name, ['admin', 'teacher', 'student']))
                                <small class="text-muted">System roles cannot be edited.</small>
                            @else
                                <small class="text-muted">Enter a unique role name</small>
                            @endif
                            @error('role_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary"
                                    {{ in_array($role->role_name, ['admin', 'teacher', 'student']) ? 'disabled' : '' }}>
                                <i class="fas fa-save me-2"></i> Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Assignments')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold text-gradient mb-0">
                <i class="fas fa-tasks me-2 text-primary"></i> Assignments
            </h1>
            <p class="text-muted mt-2">Manage and track all course assignments</p>
        </div>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <a href="{{ route('assignments.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i> Create Assignment
        </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('assignments.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">
                        <i class="fas fa-filter me-1"></i> Filter by Course
                    </label>
                    <select name="course_id" class="form-select bg-light border-0 rounded-3">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->course_id }}" {{ request('course_id') == $course->course_id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">
                        <i class="fas fa-flag-checkered me-1"></i> Filter by Status
                    </label>
                    <select name="status" class="form-select bg-light border-0 rounded-3">
                        <option value="">All Status</option>
                        <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>📄 Draft</option>
                        <option value="Published" {{ request('status') == 'Published' ? 'selected' : '' }}>🚀 Published</option>
                        <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>🔒 Closed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">
                        <i class="fas fa-search me-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assignments Table Card -->
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">
                    <i class="fas fa-list me-1"></i> Showing {{ $assignments->firstItem() ?? 0 }} - {{ $assignments->lastItem() ?? 0 }} of {{ $assignments->total() }} assignments
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="py-3">Course</th>
                            <th class="py-3">Teacher</th>
                            <th class="text-center py-3">Marks</th>
                            <th class="py-3">Due Date</th>
                            <th class="text-center py-3">Submissions</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td class="px-4">
                                <a href="{{ route('assignments.show', $assignment->assignment_id) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $assignment->title }}
                                </a>
                             </td>
                            <td>
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                    <i class="fas fa-book text-primary me-1"></i> {{ $assignment->course->course_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user-graduate text-primary fa-xs"></i>
                                        </div>
                                    </div>
                                    <span>{{ $assignment->creator->full_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-primary">{{ $assignment->total_marks }}</span>
                            </td>
                            <td>
                                @php
                                    $dueDate = $assignment->due_date;
                                    $isOverdue = $dueDate < now();
                                    $daysLeft = now()->diffInDays($dueDate, false);
                                @endphp
                                <div class="d-flex flex-column">
                                    <span class="{{ $isOverdue ? 'text-danger' : 'text-success' }} fw-semibold">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $dueDate->format('M d, Y') }}
                                    </span>
                                    <small class="{{ $isOverdue ? 'text-danger' : 'text-muted' }}">
                                        @if($isOverdue)
                                            <i class="fas fa-exclamation-triangle me-1"></i> Overdue
                                        @elseif($daysLeft == 0)
                                            <i class="fas fa-clock me-1"></i> Due today
                                        @else
                                            <i class="fas fa-hourglass-half me-1"></i> {{ $daysLeft }} days left
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                    <i class="fas fa-paper-plane me-1"></i> {{ $assignment->submissions_count ?? $assignment->submissions->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusConfig = [
                                        'Published' => ['class' => 'success', 'icon' => 'fa-check-circle'],
                                        'Draft' => ['class' => 'warning', 'icon' => 'fa-edit'],
                                        'Closed' => ['class' => 'secondary', 'icon' => 'fa-lock'],
                                    ];
                                    $config = $statusConfig[$assignment->status] ?? ['class' => 'info', 'icon' => 'fa-info-circle'];
                                @endphp
                                <span class="badge bg-{{ $config['class'] }} bg-opacity-10 text-{{ $config['class'] }} px-3 py-2 rounded-pill">
                                    <i class="fas {{ $config['icon'] }} me-1"></i> {{ $assignment->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('assignments.show', $assignment->assignment_id) }}" class="btn btn-sm btn-outline-info rounded-3 me-1" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <a href="{{ route('assignments.edit', $assignment->assignment_id) }}" class="btn btn-sm btn-outline-warning rounded-3 me-1" title="Edit Assignment">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(Auth::user()->role_id == 3)
                                    <a href="{{ route('student.submissions.create', $assignment->assignment_id) }}" class="btn btn-sm btn-outline-success rounded-3" title="Submit Assignment">
                                        <i class="fas fa-paper-plane"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">No assignments found</h5>
                                    <p class="text-muted small">Get started by creating your first assignment</p>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <a href="{{ route('assignments.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Create Assignment
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0 py-3 px-4">
            <div class="d-flex justify-content-center">
                {{ $assignments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.04);
        transition: all 0.3s ease;
    }
    .btn-group .btn {
        transition: all 0.2s ease;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .form-select, .btn {
        cursor: pointer;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<style>
    .stats-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
        background: white;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.1) !important;
    }
    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quick-action-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #e9ecef;
        border-radius: 1rem;
    }
    .quick-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        border-color: transparent;
    }
    .course-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        border-radius: 1rem;
        overflow: hidden;
    }
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.1);
    }
    .deadline-urgent {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
    }
    .deadline-warning {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }
    .deadline-normal {
        background-color: #d1e7dd;
        border-left: 4px solid #198754;
    }
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        color: white;
    }
</style>

<div class="container-fluid py-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner p-4 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-2">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Welcome back, {{ Auth::user()->full_name }}!
                        </h2>
                        <p class="mb-0 opacity-90">
                            Manage your courses, assignments, and track student submissions from your teacher dashboard.
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-chalkboard-user fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-1">My Courses</h6>
                            <h2 class="fw-bold mb-0 text-primary">{{ $totalCourses }}</h2>
                        </div>
                        <div class="stats-icon bg-primary bg-opacity-10">
                            <i class="fas fa-book fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small">
                            <i class="fas fa-check-circle me-1"></i> Active courses
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-1">Total Assignments</h6>
                            <h2 class="fw-bold mb-0 text-success">{{ $totalAssignments }}</h2>
                        </div>
                        <div class="stats-icon bg-success bg-opacity-10">
                            <i class="fas fa-tasks fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">
                            <i class="fas fa-plus-circle me-1"></i> Created
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-1">Total Submissions</h6>
                            <h2 class="fw-bold mb-0 text-info">{{ $totalSubmissions }}</h2>
                        </div>
                        <div class="stats-icon bg-info bg-opacity-10">
                            <i class="fas fa-paper-plane fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">
                            <i class="fas fa-download me-1"></i> Received
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-1">Pending Grading</h6>
                            <h2 class="fw-bold mb-0 text-warning">{{ $pendingGrading }}</h2>
                        </div>
                        <div class="stats-icon bg-warning bg-opacity-10">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">
                            <i class="fas fa-clock me-1"></i> Need review
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-bolt text-warning me-2"></i> Quick Actions
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('courses.create') }}" class="text-decoration-none">
                                <div class="quick-action-card p-3 text-center">
                                    <i class="fas fa-plus-circle fa-3x text-primary mb-2"></i>
                                    <h6 class="mb-0 fw-bold">Create Course</h6>
                                    <small class="text-muted">Add new course</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('assignments.create') }}" class="text-decoration-none">
                                <div class="quick-action-card p-3 text-center">
                                    <i class="fas fa-plus-circle fa-3x text-success mb-2"></i>
                                    <h6 class="mb-0 fw-bold">Create Assignment</h6>
                                    <small class="text-muted">Add new assignment</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('grades.index') }}" class="text-decoration-none">
                                <div class="quick-action-card p-3 text-center">
                                    <i class="fas fa-star fa-3x text-warning mb-2"></i>
                                    <h6 class="mb-0 fw-bold">Grade Submissions</h6>
                                    <small class="text-muted">Review & grade</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('enrollments.index') }}" class="text-decoration-none">
                                <div class="quick-action-card p-3 text-center">
                                    <i class="fas fa-users fa-3x text-info mb-2"></i>
                                    <h6 class="mb-0 fw-bold">Manage Enrollments</h6>
                                    <small class="text-muted">Add/remove students</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-book-open text-primary me-2"></i> My Courses
                    </h5>
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @forelse($myCourses as $course)
                            <div class="col-md-6 col-lg-4">
                                <div class="course-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                            </div>
                                            <span class="badge bg-success">
                                                {{ $course->enrollments_count ?? 0 }} Students
                                            </span>
                                        </div>
                                        <h5 class="fw-bold mb-2">{{ $course->course_name }}</h5>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-code me-1"></i> Code: {{ $course->course_code }}
                                        </p>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($course->description ?? 'No description', 80) }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 pb-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('courses.show', $course->course_id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            <a href="{{ route('assignments.index', ['course_id' => $course->course_id]) }}" class="btn btn-sm btn-outline-success flex-grow-1">
                                                <i class="fas fa-tasks me-1"></i> Assignments
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Courses Yet</h5>
                                    <p>Click "Create Course" to add your first course.</p>
                                    <a href="{{ route('courses.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i> Create Course
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Assignments -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-tasks text-success me-2"></i> Recent Assignments
                    </h5>
                    <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Due Date</th>
                                    <th>Submissions</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myAssignments as $assignment)
                                    @php
                                        $subCount = $assignment->submissions_count ?? $assignment->submissions()->count();
                                        $pendingCount = $assignment->submissions()->whereDoesntHave('grade')->count();
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('assignments.show', $assignment->assignment_id) }}" class="text-decoration-none fw-bold">
                                                {{ $assignment->title }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $assignment->course->course_name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                                            {{ $assignment->due_date->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $subCount }}</span>
                                            <br>
                                            <small>{{ $pendingCount }} pending</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('grades.by-assignment', $assignment->assignment_id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-star me-1"></i> Grade
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No assignments created yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-clock text-warning me-2"></i> Recent Submissions
                    </h5>
                    <a href="{{ route('submissions.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Assignment</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSubmissions as $submission)
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-graduate text-primary me-1"></i>
                                            {{ $submission->student->full_name ?? 'Student' }}
                                        </td>
                                        <td>{{ $submission->assignment->title ?? 'N/A' }}</td>
                                        <td>{{ $submission->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if($submission->grade)
                                                <span class="badge bg-success">Graded</span>
                                                <br>
                                                <small>{{ $submission->grade->marks_obtained }}/{{ $submission->assignment->total_marks ?? 100 }}</small>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                                <br>
                                                <a href="{{ route('grades.create') }}?submission_id={{ $submission->submission_id }}" class="btn btn-sm btn-link p-0">
                                                    Grade Now
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No recent submissions.
                                         </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Deadlines -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-hourglass-half text-danger me-2"></i> Upcoming Deadlines
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Due Date</th>
                                    <th>Submissions</th>
                                    <th>Pending</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingDeadlines as $assignment)
                                    @php
                                        $subCount = $assignment->submissions_count ?? $assignment->submissions()->count();
                                        $pendingCount = $assignment->submissions()->whereDoesntHave('grade')->count();
                                        $daysLeft = now()->diffInDays($assignment->due_date, false);
                                        $urgencyClass = $daysLeft <= 2 ? 'deadline-urgent' : ($daysLeft <= 5 ? 'deadline-warning' : 'deadline-normal');
                                    @endphp
                                    <tr class="{{ $urgencyClass }}">
                                        <td class="fw-bold">{{ $assignment->title }}</td>
                                        <td>{{ $assignment->course->course_name ?? 'N/A' }}</td>
                                        <td>
                                            {{ $assignment->due_date->format('M d, Y H:i') }}
                                            @if($daysLeft <= 2)
                                                <span class="badge bg-danger ms-2">Urgent</span>
                                            @elseif($daysLeft <= 5)
                                                <span class="badge bg-warning ms-2">Soon</span>
                                            @endif
                                        </td>
                                        <td>{{ $subCount }}</td>
                                        <td>{{ $pendingCount }}</td>
                                        <td>
                                            <a href="{{ route('grades.by-assignment', $assignment->assignment_id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-star me-1"></i> Grade
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            No upcoming deadlines.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

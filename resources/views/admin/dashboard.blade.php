@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-crown me-2"></i> Welcome back, {{ Auth::user()->full_name }}!
                            </h2>
                            <p class="mb-0 opacity-90">
                                Here's your complete overview of the Assignment Submission System.
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-chalkboard-user fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i> +{{ $newUsersThisMonth }} this month
                            </small>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Students</h6>
                            <h2 class="fw-bold mb-0">{{ $totalStudents }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-user-graduate me-1"></i> Active learners
                            </small>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Teachers</h6>
                            <h2 class="fw-bold mb-0">{{ $totalTeachers }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-chalkboard-user me-1"></i> Educators
                            </small>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-chalkboard-user fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Courses</h6>
                            <h2 class="fw-bold mb-0">{{ $totalCourses }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-book me-1"></i> Available
                            </small>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-book fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Assignments</h6>
                            <h2 class="fw-bold mb-0">{{ $totalAssignments }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-tasks me-1"></i> Created
                            </small>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="fas fa-tasks fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Submissions</h6>
                            <h2 class="fw-bold mb-0">{{ $totalSubmissions }}</h2>
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i> {{ $gradedSubmissions }} graded
                            </small>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-paper-plane fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending Grading</h6>
                            <h2 class="fw-bold mb-0 text-warning">{{ $pendingGrading }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-hourglass-half me-1"></i> Awaiting review
                            </small>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Average Score</h6>
                            <h2 class="fw-bold mb-0">{{ round($averageScore) }}%</h2>
                            <small class="text-muted">
                                <i class="fas fa-chart-line me-1"></i> Overall performance
                            </small>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-chart-line fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Submissions by Course
                    </h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="submissionsChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i> Grade Distribution
                    </h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="gradesChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-4">
        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-users text-primary me-2"></i> Recent Users
                    </h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush">
                        @forelse($recentUsers as $user)
                            <div class="list-group-item bg-transparent px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->full_name }}</h6>
                                            <small class="text-muted">{{ $user->email }} • {{ ucfirst($user->role->role_name ?? 'User') }}</small>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">No recent users</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-clock text-warning me-2"></i> Recent Submissions
                    </h5>
                    <a href="{{ route('submissions.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush">
                        @forelse($recentSubmissions as $submission)
                            <div class="list-group-item bg-transparent px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                        <small class="text-muted">
                                            by {{ $submission->student->full_name ?? 'Student' }} •
                                            {{ $submission->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    @if($submission->grade)
                                        <span class="badge bg-success">Graded</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">No recent submissions</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Distribution Details -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-simple text-info me-2"></i> Grade Distribution Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @foreach($gradeLabels as $index => $grade)
                            @php
                                $total = $gradeData->sum();
                                $percentage = $total > 0 ? ($gradeData[$index] / $total) * 100 : 0;
                                $colors = ['success', 'info', 'warning', 'orange', 'danger'];
                                $color = $colors[$index] ?? 'secondary';
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Grade {{ $grade }}</span>
                                    <span>{{ $gradeData[$index] }} students ({{ round($percentage) }}%)</span>
                                </div>
                                <div class="progress bg-light rounded-pill" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $percentage }}%; border-radius: 10px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Submissions by Course Chart
    const ctx1 = document.getElementById('submissionsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($courseLabels),
            datasets: [{
                label: 'Number of Submissions',
                data: @json($submissionData),
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderRadius: 10,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { backgroundColor: '#333' }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Grade Distribution Chart
    const ctx2 = document.getElementById('gradesChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: @json($gradeLabels),
            datasets: [{
                data: @json($gradeData),
                backgroundColor: ['#43e97b', '#4facfe', '#fa709a', '#feca57', '#ff6b6b'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { backgroundColor: '#333' }
            },
            cutout: '60%'
        }
    });
});
</script>
@endpush

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .list-group-item {
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        transform: translateX(5px);
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endsection

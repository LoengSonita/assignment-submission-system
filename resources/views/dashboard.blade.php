@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        background: var(--primary-gradient);
        color: white;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .section-card {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .section-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .deadline-item {
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .deadline-item:hover {
        transform: translateX(5px);
        background: #f8f9fa;
    }

    .deadline-urgent { border-left-color: #dc3545; }
    .deadline-warning { border-left-color: #ffc107; }
    .deadline-normal { border-left-color: #28a745; }

    .progress-bar-custom {
        background: var(--primary-gradient);
        border-radius: 10px;
        height: 8px;
    }

    .welcome-banner {
        background: var(--primary-gradient);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '✨';
        position: absolute;
        font-size: 150px;
        right: 20px;
        bottom: -30px;
        opacity: 0.1;
    }

    .badge-role {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-role.admin { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .badge-role.teacher { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .badge-role.student { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }

    .activity-item {
        position: relative;
        margin-bottom: 25px;
    }

    .activity-dot {
        position: absolute;
        left: -26px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #764ba2;
        border: 2px solid white;
        box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.2);
    }

    .grade-chart-bar {
        transition: width 1s ease;
        background: var(--primary-gradient);
        border-radius: 10px;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease forwards;
    }
</style>

<div class="container py-4">

    <!-- Welcome Banner -->
    <div class="welcome-banner text-white p-5 mb-4 animate-fadeInUp">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold mb-3">
                    Welcome back, {{ Auth::user()->full_name }}! 👋
                </h1>
                <p class="lead mb-0 opacity-90">
                    Here's what's happening with your learning journey today.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <div class="bg-white bg-opacity-20 rounded-3 p-3 d-inline-block">
                    <i class="fas fa-graduation-cap fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="stat-number">{{ $totalCourses }}</span>
                </div>
                <h6 class="text-muted mb-1">Total Courses</h6>
                <h5 class="fw-bold mb-0">Active Learning</h5>
                <small class="text-muted">{{ $totalCourses > 0 ? '+2 new this month' : 'No courses yet' }}</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 animate-fadeInUp" style="animation-delay: 0.2s">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: var(--success-gradient);">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <span class="stat-number" style="background: var(--success-gradient); -webkit-background-clip: text;">{{ $totalAssignments }}</span>
                </div>
                <h6 class="text-muted mb-1">Total Assignments</h6>
                <h5 class="fw-bold mb-0">Pending Tasks</h5>
                <small class="text-muted">{{ $upcomingDeadlines->count() }} due this week</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 animate-fadeInUp" style="animation-delay: 0.3s">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: var(--warning-gradient);">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <span class="stat-number" style="background: var(--warning-gradient); -webkit-background-clip: text;">{{ $totalSubmissions }}</span>
                </div>
                <h6 class="text-muted mb-1">Total Submissions</h6>
                <h5 class="fw-bold mb-0">{{ $gradedSubmissions }} Graded</h5>
                <small class="text-muted">{{ $pendingGrading }} awaiting grading</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 animate-fadeInUp" style="animation-delay: 0.4s">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background: var(--info-gradient);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="stat-number" style="background: var(--info-gradient); -webkit-background-clip: text;">{{ round($averageScore) }}%</span>
                </div>
                <h6 class="text-muted mb-1">Average Score</h6>
                <h5 class="fw-bold mb-0">Class Performance</h5>
                <small class="text-muted">Overall achievement</small>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <!-- Submissions by Course Chart -->
        <div class="col-lg-6 animate-fadeInUp" style="animation-delay: 0.5s">
            <div class="section-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Submissions by Course
                    </h4>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Last 30 days</span>
                </div>
                <canvas id="submissionsChart" height="250"></canvas>
            </div>
        </div>

        <!-- Grade Distribution Chart -->
        <div class="col-lg-6 animate-fadeInUp" style="animation-delay: 0.6s">
            <div class="section-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i> Grade Distribution
                    </h4>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Overall</span>
                </div>
                <canvas id="gradesChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-4">
        <!-- Recent Submissions -->
        <div class="col-lg-6 animate-fadeInUp" style="animation-delay: 0.7s">
            <div class="section-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-clock text-info me-2"></i> Recent Activity
                    </h4>
                    <i class="fas fa-ellipsis-h text-muted"></i>
                </div>
                <div class="activity-timeline">
                    @forelse($recentSubmissions as $submission)
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-user me-1"></i> {{ $submission->student->full_name ?? 'Student' }}
                                        <br>
                                        <i class="fas fa-calendar me-1"></i> {{ $submission->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if($submission->grade)
                                    <span class="badge bg-success">✓ Graded</span>
                                @else
                                    <span class="badge bg-warning">⏳ Pending</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No recent submissions</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="col-lg-6 animate-fadeInUp" style="animation-delay: 0.8s">
            <div class="section-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-hourglass-half text-warning me-2"></i> Upcoming Deadlines
                    </h4>
                    <i class="fas fa-ellipsis-h text-muted"></i>
                </div>
                <div class="space-y-3">
                    @forelse($upcomingDeadlines as $assignment)
                        @php
                            $daysLeft = now()->diffInDays($assignment->due_date, false);
                            $statusClass = $daysLeft <= 2 ? 'deadline-urgent' : ($daysLeft <= 5 ? 'deadline-warning' : 'deadline-normal');
                            $statusText = $daysLeft <= 2 ? '⚠️ Urgent' : ($daysLeft <= 5 ? '📅 Soon' : '✅ On Track');
                        @endphp
                        <div class="deadline-item {{ $statusClass }} p-3 rounded-3 mb-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $assignment->title }}</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-book me-1"></i> {{ $assignment->course->course_name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <div class="small fw-bold">{{ $statusText }}</div>
                                    <div class="text-muted small">
                                        {{ $assignment->due_date->format('M d, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No upcoming deadlines</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Distribution Bars (if no chart data) -->
    @if($gradeLabels && $gradeLabels->count() > 0)
    <div class="row mt-4 animate-fadeInUp" style="animation-delay: 0.9s">
        <div class="col-12">
            <div class="section-card p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-trophy text-warning me-2"></i> Grade Distribution Details
                </h4>
                @foreach($gradeLabels as $index => $grade)
                    @php
                        $total = $gradeData->sum();
                        $percentage = $total > 0 ? ($gradeData[$index] / $total) * 100 : 0;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">{{ $grade }} Grade</span>
                            <span class="text-muted">{{ $gradeData[$index] }} students ({{ round($percentage) }}%)</span>
                        </div>
                        <div class="progress bg-light rounded-pill" style="height: 10px;">
                            <div class="progress-bar-custom" style="width: {{ $percentage }}%; height: 10px;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

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
                tooltip: { backgroundColor: '#333', titleColor: '#fff', bodyColor: '#fff' }
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
@endsection

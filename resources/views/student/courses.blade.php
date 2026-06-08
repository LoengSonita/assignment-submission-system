@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-book-open me-2"></i> My Enrolled Courses
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @forelse($enrollments as $enrollment)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow-sm hover-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="course-icon bg-primary text-white rounded-circle p-3">
                                                <i class="fas fa-graduation-cap fa-2x"></i>
                                            </div>
                                            <span class="badge bg-success">Enrolled</span>
                                        </div>
                                        <h5 class="card-title fw-bold">{{ $enrollment->course->course_name ?? 'N/A' }}</h5>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-code me-1"></i> Code: {{ $enrollment->course->course_code ?? 'N/A' }}
                                        </p>
                                        <p class="card-text">{{ Str::limit($enrollment->course->description ?? 'No description', 100) }}</p>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-chalkboard-user me-1"></i> Teacher: {{ $enrollment->course->creator->full_name ?? 'N/A' }}
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-calendar-alt me-1"></i> Enrolled: {{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 pb-3">
                                        <a href="{{ route('courses.show', $enrollment->course->course_id) }}" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i> View Course
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-book fa-3x mb-3"></i>
                                    <h5>No Courses Enrolled</h5>
                                    <p>You haven't enrolled in any courses yet.</p>
                                    <a href="{{ route('courses.index') }}" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i> Browse Courses
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .course-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endsection

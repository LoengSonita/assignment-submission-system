@extends('layouts.app')

@section('title', 'My Feedback')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-comment-dots me-2"></i> My Feedback
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($feedbacks->count() > 0)
                        <div class="row">
                            @foreach($feedbacks as $feedback)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-header bg-transparent border-0 pt-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h5 class="mb-0 text-primary">
                                                    <i class="fas fa-tasks me-2"></i>
                                                    {{ $feedback->submission->assignment->title ?? 'N/A' }}
                                                </h5>
                                                <span class="badge bg-info">
                                                    {{ $feedback->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-book me-1"></i>
                                                <strong>Course:</strong> {{ $feedback->submission->assignment->course->course_name ?? 'N/A' }}
                                            </p>
                                            <p class="text-muted mb-3">
                                                <i class="fas fa-chalkboard-user me-1"></i>
                                                <strong>Teacher:</strong> {{ $feedback->teacher->full_name ?? 'N/A' }}
                                            </p>
                                            <div class="alert alert-light border-start border-4 border-primary mt-3">
                                                <i class="fas fa-quote-left text-primary me-2"></i>
                                                {{ $feedback->comment }}
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 pb-3">
                                            @if($feedback->submission->grade)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            Grade: {{ $feedback->submission->grade->grade }}
                                                        </span>
                                                    </div>
                                                    <div class="text-muted small">
                                                        <i class="fas fa-star me-1"></i>
                                                        {{ $feedback->submission->grade->marks_obtained }}/{{ $feedback->submission->assignment->total_marks ?? 100 }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-muted small">
                                                    <i class="fas fa-hourglass-half me-1"></i>
                                                    Not graded yet
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Section -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">Feedback Summary</h6>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <div class="display-6 fw-bold text-primary">{{ $feedbacks->count() }}</div>
                                                <div class="text-muted small">Total Feedback</div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div class="display-6 fw-bold text-success">
                                                    {{ $feedbacks->where('submission.grade', '!=', null)->count() }}
                                                </div>
                                                <div class="text-muted small">With Grades</div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                @php
                                                    $avgMarks = $feedbacks->where('submission.grade', '!=', null)->avg(function($f) {
                                                        return $f->submission->grade->marks_obtained ?? 0;
                                                    });
                                                @endphp
                                                <div class="display-6 fw-bold text-info">{{ number_format($avgMarks, 1) }}%</div>
                                                <div class="text-muted small">Average Score</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <h5>No Feedback Yet</h5>
                            <p>You haven't received any feedback from teachers yet.</p>
                            <p class="small">Submit assignments and wait for teachers to provide feedback.</p>
                            <a href="{{ route('assignments.index') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-tasks me-1"></i> Browse Assignments
                            </a>
                        </div>
                    @endif
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .border-start-primary {
        border-left-color: #667eea !important;
    }
</style>
@endsection

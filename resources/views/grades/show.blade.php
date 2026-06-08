@extends('layouts.app')

@section('title', 'Grade Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Grade Details
                    </h5>
                    <div>
                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <a href="{{ route('grades.edit', $grade->grade_id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('grades.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Grade ID:</div>
                        <div class="col-md-9">{{ $grade->grade_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Student:</div>
                        <div class="col-md-9">
                            <i class="fas fa-user-graduate me-1"></i>
                            {{ $grade->submission->student->full_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Assignment:</div>
                        <div class="col-md-9">
                            <i class="fas fa-tasks me-1"></i>
                            {{ $grade->submission->assignment->title ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Course:</div>
                        <div class="col-md-9">
                            <i class="fas fa-book me-1"></i>
                            {{ $grade->submission->assignment->course->course_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Marks Obtained:</div>
                        <div class="col-md-9">
                            <strong class="fs-4">{{ $grade->marks_obtained }}</strong> / {{ $grade->submission->assignment->total_marks ?? 'N/A' }}
                            @php
                                $percentage = ($grade->marks_obtained / ($grade->submission->assignment->total_marks ?? 1)) * 100;
                                $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'info' : ($percentage >= 40 ? 'warning' : 'danger'));
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} ms-2 px-3 py-2">{{ round($percentage) }}%</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Grade:</div>
                        <div class="col-md-9">
                            @php
                                $gradeClass = match($grade->grade) {
                                    'A+', 'A' => 'success',
                                    'B' => 'info',
                                    'C', 'D' => 'warning',
                                    default => 'danger'
                                };
                            @endphp
                            <span class="badge bg-{{ $gradeClass }} fs-5 px-4 py-2">
                                {{ $grade->grade }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Graded By:</div>
                        <div class="col-md-9">
                            <i class="fas fa-chalkboard-user me-1"></i>
                            {{ $grade->grader->full_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold text-primary">Graded At:</div>
                        <div class="col-md-9">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($grade->graded_at)->format('F d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

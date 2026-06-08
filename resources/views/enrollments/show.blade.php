@extends('layouts.app')

@section('title', 'Enrollment Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Enrollment Details
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Enrollment ID:</div>
                        <div class="col-md-8">{{ $enrollment->enrollment_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Student Name:</div>
                        <div class="col-md-8">
                            <i class="fas fa-user-graduate text-primary me-1"></i>
                            {{ $enrollment->student->full_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Student Email:</div>
                        <div class="col-md-8">{{ $enrollment->student->email ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Course Name:</div>
                        <div class="col-md-8">
                            <i class="fas fa-book text-success me-1"></i>
                            {{ $enrollment->course->course_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Course Code:</div>
                        <div class="col-md-8">{{ $enrollment->course->course_code ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Enrolled Date:</div>
                        <div class="col-md-8">
                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                            {{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('F d, Y H:i') : 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $enrollment->created_at->format('F d, Y H:i') }}</div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                        <div>
                            <a href="{{ route('enrollments.edit', $enrollment->enrollment_id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i> Delete
                            </button>
                        </div>
                    </div>

                    <form id="delete-form" action="{{ route('enrollments.destroy', $enrollment->enrollment_id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this enrollment?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection

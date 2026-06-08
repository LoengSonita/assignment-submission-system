@extends('layouts.app')

@section('title', 'Edit Enrollment')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Enrollment
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('enrollments.update', $enrollment->enrollment_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user-graduate me-1 text-primary"></i> Student <span class="text-danger">*</span>
                            </label>
                            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->user_id }}" {{ old('student_id', $enrollment->student_id) == $student->user_id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-book me-1 text-primary"></i> Course <span class="text-danger">*</span>
                            </label>
                            <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}" {{ old('course_id', $enrollment->course_id) == $course->course_id ? 'selected' : '' }}>
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Enrollment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

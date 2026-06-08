@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Assignment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assignments.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Course <span class="text-danger">*</span></label>
                            <select name="course_id" class="form-control @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>Total Marks <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_marks" class="form-control @error('total_marks') is-invalid @enderror"
                                           value="{{ old('total_marks', 100) }}" required>
                                    @error('total_marks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                           value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label>Due Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                                           value="{{ old('due_date', now()->addDays(7)->format('Y-m-d\TH:i')) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="allow_late_submission" class="form-check-input" value="1" {{ old('allow_late_submission') ? 'checked' : '' }}>
                                        <label class="form-check-label">Allow Late Submission</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                        <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

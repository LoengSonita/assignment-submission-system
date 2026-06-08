@extends('layouts.app')

@section('title', 'Add Grade')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Add New Grade
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('grades.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="submission_id" class="form-label fw-bold">
                                <i class="fas fa-paper-plane me-1 text-primary"></i> Submission <span class="text-danger">*</span>
                            </label>
                            <select name="submission_id" id="submission_id" class="form-select @error('submission_id') is-invalid @enderror" required>
                                <option value="">-- Select Submission --</option>
                                @foreach($submissions as $submission)
                                    <option value="{{ $submission->submission_id }}" {{ request('submission_id') == $submission->submission_id ? 'selected' : '' }}>
                                        {{ $submission->student->full_name }} - {{ $submission->assignment->title }}
                                        (Submitted: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('submission_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marks_obtained" class="form-label fw-bold">
                                    <i class="fas fa-percent me-1 text-primary"></i> Marks Obtained <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" name="marks_obtained" id="marks_obtained"
                                       class="form-control @error('marks_obtained') is-invalid @enderror"
                                       value="{{ old('marks_obtained') }}" required>
                                @error('marks_obtained')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label fw-bold">
                                    <i class="fas fa-award me-1 text-primary"></i> Grade <span class="text-danger">*</span>
                                </label>
                                <select name="grade" id="grade" class="form-select @error('grade') is-invalid @enderror" required>
                                    <option value="">-- Select Grade --</option>
                                    <option value="A+" {{ old('grade') == 'A+' ? 'selected' : '' }}>A+ (90-100) - Excellent</option>
                                    <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A (80-89) - Very Good</option>
                                    <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B (70-79) - Good</option>
                                    <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C (60-69) - Average</option>
                                    <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D (50-59) - Poor</option>
                                    <option value="F" {{ old('grade') == 'F' ? 'selected' : '' }}>F (Below 50) - Fail</option>
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

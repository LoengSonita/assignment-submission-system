@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Grade
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <p class="mb-1"><strong>Student:</strong> {{ $grade->submission->student->full_name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Assignment:</strong> {{ $grade->submission->assignment->title ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Total Marks:</strong> {{ $grade->submission->assignment->total_marks ?? 100 }}</p>
                    </div>

                    <form action="{{ route('grades.update', $grade->grade_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marks_obtained" class="form-label fw-bold">
                                    <i class="fas fa-percent me-1 text-primary"></i> Marks Obtained <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" name="marks_obtained" id="marks_obtained"
                                       class="form-control @error('marks_obtained') is-invalid @enderror"
                                       value="{{ old('marks_obtained', $grade->marks_obtained) }}" required>
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
                                    <option value="A+" {{ old('grade', $grade->grade) == 'A+' ? 'selected' : '' }}>A+ (90-100) - Excellent</option>
                                    <option value="A" {{ old('grade', $grade->grade) == 'A' ? 'selected' : '' }}>A (80-89) - Very Good</option>
                                    <option value="B" {{ old('grade', $grade->grade) == 'B' ? 'selected' : '' }}>B (70-79) - Good</option>
                                    <option value="C" {{ old('grade', $grade->grade) == 'C' ? 'selected' : '' }}>C (60-69) - Average</option>
                                    <option value="D" {{ old('grade', $grade->grade) == 'D' ? 'selected' : '' }}>D (50-59) - Poor</option>
                                    <option value="F" {{ old('grade', $grade->grade) == 'F' ? 'selected' : '' }}>F (Below 50) - Fail</option>
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label fw-bold">
                                <i class="fas fa-comment me-1 text-primary"></i> Feedback (Optional)
                            </label>
                            <textarea name="feedback" id="feedback" rows="3" class="form-control @error('feedback') is-invalid @enderror"
                                      placeholder="Add additional comments for the student...">{{ old('feedback', $grade->feedback ?? '') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

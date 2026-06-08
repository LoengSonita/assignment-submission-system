@extends('layouts.app')

@section('title', 'Add Feedback')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-comment-dots me-2"></i> Add Feedback for Submission
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <h6 class="mb-2">Submission Details:</h6>
                        <p class="mb-1"><strong>Student:</strong> {{ $submission->student->full_name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Assignment:</strong> {{ $submission->assignment->title ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Submitted:</strong> {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y H:i') }}</p>
                    </div>

                    <form method="POST" action="{{ route('feedbacks.store') }}">
                        @csrf
                        <input type="hidden" name="submission_id" value="{{ $submission->submission_id }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-quote-left me-1 text-primary"></i> Feedback Comment <span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" rows="6" class="form-control @error('comment') is-invalid @enderror"
                                      placeholder="Write your feedback for the student..." required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Provide constructive feedback to help the student improve.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('submissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

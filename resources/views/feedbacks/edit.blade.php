@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Feedback
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <p class="mb-1"><strong>Student:</strong> {{ $feedback->submission->student->full_name ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Assignment:</strong> {{ $feedback->submission->assignment->title ?? 'N/A' }}</p>
                    </div>

                    <form method="POST" action="{{ route('feedbacks.update', $feedback->feedback_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-quote-left me-1 text-primary"></i> Feedback Comment <span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" rows="6" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $feedback->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

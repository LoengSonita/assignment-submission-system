@extends('layouts.app')

@section('title', 'Submit Assignment')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i> Submit Assignment
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Assignment Details -->
                    <div class="alert alert-info mb-4">
                        <h5 class="mb-2">{{ $assignment->title }}</h5>
                        <p class="mb-1"><strong>Course:</strong> {{ $assignment->course->course_name }}</p>
                        <p class="mb-1"><strong>Due Date:</strong> {{ $assignment->due_date->format('F d, Y H:i') }}</p>
                        <p class="mb-0"><strong>Total Marks:</strong> {{ $assignment->total_marks }}</p>
                    </div>

                    @if(isset($existingSubmission))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            You have already submitted this assignment. Resubmitting will replace your previous submission.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->assignment_id }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-align-left me-1 text-primary"></i> Your Answer / Comments
                            </label>
                            <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Write your answer or any comments here...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-paperclip me-1 text-primary"></i> Attachment (Optional)
                            </label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.zip,.txt">
                            <small class="text-muted">Max file size: 10MB. Allowed: PDF, DOC, DOCX, ZIP, TXT</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.show', $assignment->assignment_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i> Submit Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Grade for Submission</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('grades.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="submission_id" class="form-label">Select Submission *</label>
                            <select name="submission_id" id="submission_id" class="form-select @error('submission_id') is-invalid @enderror" required>
                                <option value="">Choose Submission</option>
                                @foreach($submissions as $submission)
                                    <option value="{{ $submission->submission_id }}" {{ old('submission_id') == $submission->submission_id ? 'selected' : '' }}>
                                        {{ $submission->student->full_name }} - {{ $submission->assignment->title }}
                                        (Submitted: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('submission_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marks_obtained" class="form-label">Marks Obtained *</label>
                                <input type="number" step="0.01" name="marks_obtained" id="marks_obtained" class="form-control @error('marks_obtained') is-invalid @enderror" value="{{ old('marks_obtained') }}" required>
                                @error('marks_obtained')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label">Grade *</label>
                                <select name="grade" id="grade" class="form-select @error('grade') is-invalid @enderror" required>
                                    <option value="">Select Grade</option>
                                    <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                    <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B (Good)</option>
                                    <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C (Average)</option>
                                    <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D (Poor)</option>
                                    <option value="F" {{ old('grade') == 'F' ? 'selected' : '' }}>F (Fail)</option>
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Grade</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

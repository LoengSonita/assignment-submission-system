@extends('layouts.app')

@section('title', 'Feedback Management')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i> Feedback Management
                    </h5>
                    <a href="{{ route('submissions.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Feedback
                    </a>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Assignment</th>
                                    <th>Teacher</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->feedback_id }}</td>
                                    <td>{{ $feedback->submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $feedback->submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $feedback->teacher->full_name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($feedback->comment, 50) }}</td>
                                    <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('feedbacks.show', $feedback->feedback_id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('feedbacks.edit', $feedback->feedback_id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $feedback->feedback_id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $feedback->feedback_id }}"
                                                  action="{{ route('feedbacks.destroy', $feedback->feedback_id) }}"
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                                        No feedback found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this feedback?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection

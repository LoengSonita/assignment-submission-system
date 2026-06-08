@extends('layouts.app')

@section('title', 'My Submissions')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i> My Submissions
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Submitted Date</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->submission_id }}</td>
                                    <td>
                                        <i class="fas fa-tasks text-primary me-1"></i>
                                        {{ $submission->assignment->title ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-book text-success me-1"></i>
                                        {{ $submission->assignment->course->course_name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        {{ $submission->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td>
                                        @php
                                            $isLate = $submission->is_late;
                                            $status = $submission->status;
                                        @endphp
                                        @if($status == 'submitted')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i> Submitted
                                            </span>
                                        @elseif($status == 'graded')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Graded
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="fas fa-hourglass-half me-1"></i> {{ ucfirst($status) }}
                                            </span>
                                        @endif
                                        @if($isLate)
                                            <span class="badge bg-danger mt-1">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Late
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($submission->grade)
                                            <span class="fw-bold text-success">
                                                {{ $submission->grade->marks_obtained }}/{{ $submission->assignment->total_marks ?? 100 }}
                                            </span>
                                            <br>
                                            <small class="text-muted">Grade: {{ $submission->grade->grade ?? 'N/A' }}</small>
                                        @else
                                            <span class="text-muted">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('submissions.show', $submission->submission_id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$submission->grade)
                                                <a href="{{ route('student.submissions.edit', $submission->submission_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="confirmDelete({{ $submission->submission_id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                            <form id="delete-form-{{ $submission->submission_id }}"
                                                  action="{{ route('student.submissions.destroy', $submission->submission_id) }}"
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
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        No submissions found.
                                        <br>
                                        <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Submit Assignment
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this submission?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.3s ease;
    }
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 8px;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
    }
</style>
@endsection

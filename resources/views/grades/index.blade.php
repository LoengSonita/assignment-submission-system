@extends('layouts.app')

@section('title', 'Grades Management')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i> Grades Management
                    </h5>
                    <a href="{{ route('grades.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Grade
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
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>Graded By</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td>{{ $grade->grade_id }}</td>
                                    <td>{{ $grade->submission->student->full_name ?? 'N/A' }}</td>
                                    <td>{{ $grade->submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $grade->marks_obtained }}/{{ $grade->submission->assignment->total_marks ?? 100 }}</td>
                                    <td>
                                        @php
                                            $gradeLetter = $grade->grade;
                                            $badgeClass = match($gradeLetter) {
                                                'A+', 'A' => 'success',
                                                'B' => 'info',
                                                'C' => 'warning',
                                                'D' => 'warning',
                                                default => 'danger'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $grade->grade }}</span>
                                    </td>
                                    <td>{{ $grade->grader->full_name ?? 'N/A' }}</td>
                                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('grades.show', $grade->grade_id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('grades.edit', $grade->grade_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                    onclick="confirmDelete({{ $grade->grade_id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $grade->grade_id }}"
                                                  action="{{ route('grades.destroy', $grade->grade_id) }}"
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-chart-simple fa-2x mb-2 d-block"></i>
                                        No grades found.
                                        <br>
                                        <a href="{{ route('grades.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Add First Grade
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $grades->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this grade?')) {
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
</style>
@endsection

@extends('layouts.app')

@section('title', 'Grades by Assignment')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i> Grades by Assignment
                    </h4>
                    <a href="{{ route('grades.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to All Grades
                    </a>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($grades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Marks Obtained</th>
                                        <th>Total Marks</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                        <th>Graded By</th>
                                        <th>Graded Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                    @php
                                        $totalMarks = $grade->submission->assignment->total_marks ?? 100;
                                        $percentage = ($grade->marks_obtained / $totalMarks) * 100;
                                        $badgeClass = match($grade->grade) {
                                            'A+', 'A' => 'success',
                                            'B' => 'info',
                                            'C' => 'warning',
                                            'D' => 'warning',
                                            default => 'danger'
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $grade->grade_id }}</td>
                                        <td>
                                            <i class="fas fa-user-graduate text-primary me-1"></i>
                                            {{ $grade->submission->student->full_name ?? 'N/A' }}
                                        </td>
                                        <td>{{ $grade->marks_obtained }}</td>
                                        <td>{{ $totalMarks }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar bg-{{ $badgeClass }}"
                                                         style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="small">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                                                {{ $grade->grade }}
                                            </span>
                                        </td>
                                        <td>{{ $grade->grader->full_name ?? 'N/A' }}</td>
                                        <td>{{ $grade->graded_at ? \Carbon\Carbon::parse($grade->graded_at)->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Statistics -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <div class="display-6 fw-bold text-primary">{{ $grades->count() }}</div>
                                        <div class="text-muted small">Total Students</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        @php
                                            $avgMarks = $grades->avg('marks_obtained');
                                        @endphp
                                        <div class="display-6 fw-bold text-success">{{ number_format($avgMarks, 1) }}</div>
                                        <div class="text-muted small">Average Marks</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        @php
                                            $highest = $grades->max('marks_obtained');
                                        @endphp
                                        <div class="display-6 fw-bold text-warning">{{ $highest }}</div>
                                        <div class="text-muted small">Highest Score</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        @php
                                            $passCount = $grades->filter(function($g) {
                                                return !in_array($g->grade, ['F']);
                                            })->count();
                                            $passRate = $grades->count() > 0 ? ($passCount / $grades->count()) * 100 : 0;
                                        @endphp
                                        <div class="display-6 fw-bold text-info">{{ number_format($passRate, 1) }}%</div>
                                        <div class="text-muted small">Pass Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chart-simple fa-3x mb-3"></i>
                            <h5>No Grades Found</h5>
                            <p>No grades have been assigned for this assignment yet.</p>
                            <a href="{{ route('grades.create') }}?submission_id=&assignment_id={{ $assignment_id }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i> Add First Grade
                            </a>
                        </div>
                    @endif

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
    .progress-bar {
        transition: width 0.6s ease;
    }
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 8px;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'My Grades')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i> My Grades
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Marks Obtained</th>
                                    <th>Total Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Graded Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                @php
                                    $percentage = ($grade->marks_obtained / $grade->submission->assignment->total_marks) * 100;
                                    $badgeClass = match($grade->grade) {
                                        'A+', 'A' => 'success',
                                        'B' => 'info',
                                        'C' => 'warning',
                                        default => 'danger'
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $grade->submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $grade->submission->assignment->course->course_name ?? 'N/A' }}</td>
                                    <td>{{ $grade->marks_obtained }}</td>
                                    <td>{{ $grade->submission->assignment->total_marks ?? 100 }}</td>
                                    <td>{{ number_format($percentage, 1) }}%</td>
                                    <td>
                                        <span class="badge bg-{{ $badgeClass }} fs-6 px-3 py-2">{{ $grade->grade }}</span>
                                    </td>
                                    <td>{{ $grade->graded_at ? \Carbon\Carbon::parse($grade->graded_at)->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-chart-simple fa-2x mb-2 d-block"></i>
                                        No grades found yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.3s ease;
    }
</style>
@endsection

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
                                        <th>#</th>
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
                                    @foreach($grades as $index => $grade)
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fas fa-tasks text-primary me-1"></i>
                                            {{ $grade->submission->assignment->title ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <i class="fas fa-book text-success me-1"></i>
                                            {{ $grade->submission->assignment->course->course_name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>{{ $grade->marks_obtained }}</strong>
                                        </td>
                                        <td>{{ $totalMarks }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar bg-{{ $badgeClass }}"
                                                         style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span>{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $badgeClass }} fs-6 px-3 py-2">
                                                {{ $grade->grade }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                                            {{ $grade->graded_at ? \Carbon\Carbon::parse($grade->graded_at)->format('M d, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Section -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Overall Performance</h6>
                                        @php
                                            $totalObtained = $grades->sum('marks_obtained');
                                            $totalPossible = $grades->sum(function($grade) {
                                                return $grade->submission->assignment->total_marks ?? 100;
                                            });
                                            $overallPercentage = $totalPossible > 0 ? ($totalObtained / $totalPossible) * 100 : 0;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="display-6 fw-bold">{{ number_format($overallPercentage, 1) }}%</span>
                                                <span class="text-muted">Overall</span>
                                            </div>
                                            <div class="text-end">
                                                <span class="text-muted">Total Marks:</span>
                                                <strong>{{ $totalObtained }} / {{ $totalPossible }}</strong>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height: 10px;">
                                            <div class="progress-bar bg-success" style="width: {{ $overallPercentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Grade Distribution</h6>
                                        @php
                                            $gradeCounts = [
                                                'A' => $grades->whereIn('grade', ['A+', 'A'])->count(),
                                                'B' => $grades->where('grade', 'B')->count(),
                                                'C' => $grades->where('grade', 'C')->count(),
                                                'D' => $grades->where('grade', 'D')->count(),
                                                'F' => $grades->where('grade', 'F')->count(),
                                            ];
                                        @endphp
                                        @foreach($gradeCounts as $letter => $count)
                                            @if($count > 0)
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Grade {{ $letter }}</span>
                                                    <span>{{ $count }} {{ Str::plural('subject', $count) }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chart-simple fa-3x mb-3"></i>
                            <h5>No Grades Found</h5>
                            <p>You haven't received any grades yet. Submit assignments to get graded.</p>
                            <a href="{{ route('assignments.index') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-tasks me-1"></i> Browse Assignments
                            </a>
                        </div>
                    @endif
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
    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endsection

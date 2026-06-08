<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $submission_id = $request->get('submission_id');

        $grades = Grade::with('submission.assignment', 'submission.student', 'grader')
            ->when($submission_id, function ($query, $submission_id) {
                return $query->where('submission_id', $submission_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new grade.
     */
    public function create(Request $request)
    {
        // Get submissions that don't have grades yet
        $submissions = Submission::with(['student', 'assignment'])
            ->whereDoesntHave('grade')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('grades.create', compact('submissions'));
    }

    /**
     * Store a newly created grade.
     */
    public function store(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,submission_id',
            'marks_obtained' => 'required|numeric|min:0'
        ]);

        $submission = Submission::with('assignment')->findOrFail($request->submission_id);

        // Check if grade already exists
        if ($submission->grade) {
            return redirect()->back()->with('error', 'Grade already exists for this submission.');
        }

        // Validate marks against total
        if ($request->marks_obtained > $submission->assignment->total_marks) {
            return redirect()->back()
                ->with('error', 'Marks obtained cannot exceed ' . $submission->assignment->total_marks)
                ->withInput();
        }

        // Calculate grade letter
        $gradeLetter = $this->calculateGrade($request->marks_obtained, $submission->assignment->total_marks);

        Grade::create([
            'submission_id' => $request->submission_id,
            'marks_obtained' => $request->marks_obtained,
            'grade' => $gradeLetter,
            'graded_by' => Auth::user()->user_id, // Fixed: use user_id instead of id
            'graded_at' => now()
        ]);

        // Update submission status
        $submission->update(['status' => 'graded']);

        return redirect()->route('grades.index')
            ->with('success', 'Grade assigned successfully.');
    }

    /**
     * Display the specified grade.
     */
    public function show($id)
    {
        $grade = Grade::with('submission.assignment', 'submission.student', 'grader')
            ->findOrFail($id);

        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing a grade.
     */
    public function edit($id)
    {
        $grade = Grade::with('submission.assignment')->findOrFail($id);
        $submission = $grade->submission;

        return view('grades.edit', compact('grade', 'submission'));
    }

    /**
     * Update a grade.
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $request->validate([
            'marks_obtained' => 'required|numeric|min:0'
        ]);

        $totalMarks = $grade->submission->assignment->total_marks;

        if ($request->marks_obtained > $totalMarks) {
            return redirect()->back()
                ->with('error', 'Marks obtained cannot exceed ' . $totalMarks)
                ->withInput();
        }

        $gradeLetter = $this->calculateGrade($request->marks_obtained, $totalMarks);

        $grade->update([
            'marks_obtained' => $request->marks_obtained,
            'grade' => $gradeLetter,
            'graded_by' => Auth::user()->user_id, // Fixed: use user_id
            'graded_at' => now()
        ]);

        return redirect()->route('grades.index')
            ->with('success', 'Grade updated successfully.');
    }

    /**
     * Delete a grade.
     */
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $submission = $grade->submission;

        $grade->delete();
        $submission->update(['status' => 'submitted']);

        return redirect()->route('grades.index')
            ->with('success', 'Grade deleted successfully.');
    }

    /**
     * Calculate grade letter based on percentage.
     */
    private function calculateGrade($marksObtained, $totalMarks)
    {
        $percentage = ($marksObtained / $totalMarks) * 100;

        if ($percentage >= 90) {
            return 'A+';
        } elseif ($percentage >= 80) {
            return 'A';
        } elseif ($percentage >= 70) {
            return 'B';
        } elseif ($percentage >= 60) {
            return 'C';
        } elseif ($percentage >= 50) {
            return 'D';
        } else {
            return 'F';
        }
    }

    /**
     * Display grades for a specific assignment (Teacher view).
     */
    public function byAssignment($assignment_id)
    {
        $grades = Grade::with('submission.student')
            ->whereHas('submission', function ($query) use ($assignment_id) {
                $query->where('assignment_id', $assignment_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('grades.by-assignment', compact('grades', 'assignment_id'));
    }

    /**
     * Display student's own grades.
     */
    public function myGrades()
    {
        $grades = Grade::with('submission.assignment')
            ->whereHas('submission', function ($query) {
                $query->where('student_id', Auth::user()->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.grades', compact('grades'));
    }
}

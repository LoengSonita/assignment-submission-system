<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $course_id = $request->get('course_id');
        $status = $request->get('status');

        // Load assignments with course, creator, and submissions count
        $assignments = Assignment::with(['course', 'creator'])
            ->withCount('submissions')
            ->when($course_id, function ($query, $course_id) {
                return $query->where('course_id', $course_id);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        $courses = Course::orderBy('course_name', 'asc')->get();

        return view('assignments.index', compact('assignments', 'courses'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        $courses = Course::orderBy('course_name', 'asc')->get();

        if ($courses->isEmpty()) {
            return redirect()->route('courses.index')
                ->with('error', 'Please create a course first before creating an assignment.');
        }

        return view('assignments.create', compact('courses'));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'total_marks' => 'required|numeric|min:0|max:999.99',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'allow_late_submission' => 'sometimes|boolean',
            'status' => 'required|in:Draft,Published,Closed'
        ]);

        Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'total_marks' => $request->total_marks,
            'start_date' => Carbon::parse($request->start_date),
            'due_date' => Carbon::parse($request->due_date),
            'allow_late_submission' => $request->has('allow_late_submission'),
            'created_by' => Auth::user()->user_id,
            'status' => $request->status
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    public function show($id)
    {
        // Load assignment with ALL relationships
        $assignment = Assignment::with([
            'course',
            'creator',
            'submissions.student',
            'submissions.grade'
        ])->findOrFail($id);

        return view('assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing an assignment.
     */
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        $courses = Course::orderBy('course_name', 'asc')->get();

        // Check permission (admin or creator can edit)
        if (Auth::user()->role_id != 1 && $assignment->created_by != Auth::user()->user_id) {
            return redirect()->route('assignments.index')
                ->with('error', 'You do not have permission to edit this assignment.');
        }

        return view('assignments.edit', compact('assignment', 'courses'));
    }

    /**
     * Update an assignment.
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        // Check permission
        if (Auth::user()->role_id != 1 && $assignment->created_by != Auth::user()->user_id) {
            return redirect()->route('assignments.index')
                ->with('error', 'You do not have permission to update this assignment.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'total_marks' => 'required|numeric|min:0|max:999.99',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'allow_late_submission' => 'sometimes|boolean',
            'status' => 'required|in:Draft,Published,Closed'
        ]);

        $assignment->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'total_marks' => $request->total_marks,
            'start_date' => Carbon::parse($request->start_date),
            'due_date' => Carbon::parse($request->due_date),
            'allow_late_submission' => $request->has('allow_late_submission'),
            'status' => $request->status
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Delete an assignment.
     */
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);

        // Check permission
        if (Auth::user()->role_id != 1 && $assignment->created_by != Auth::user()->user_id) {
            return redirect()->route('assignments.index')
                ->with('error', 'You do not have permission to delete this assignment.');
        }

        // Check if assignment has submissions
        if ($assignment->submissions()->count() > 0) {
            return redirect()->route('assignments.index')
                ->with('error', 'Cannot delete assignment with existing submissions.');
        }

        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }
}

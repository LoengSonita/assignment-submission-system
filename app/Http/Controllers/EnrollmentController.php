<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['course', 'student'])
            ->orderBy('enrollment_id', 'desc')
            ->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create()
    {
        $courses = Course::orderBy('course_name')->get();
        $students = User::where('role_id', 3)->orderBy('full_name')->get();

        return view('enrollments.create', compact('courses', 'students'));
    }

    /**
     * Store a newly created enrollment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'student_id' => 'required|exists:users,user_id',
        ]);

        // Check if already enrolled
        $exists = Enrollment::where('course_id', $request->course_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Student is already enrolled in this course.')
                ->withInput();
        }

        Enrollment::create([
            'course_id' => $request->course_id,
            'student_id' => $request->student_id,
            'enrolled_at' => now(),
        ]);

        return redirect()->route('enrollments.index')
            ->with('success', 'Student enrolled successfully.');
    }

    /**
     * Display the specified enrollment.
     */
    public function show($id)
    {
        $enrollment = Enrollment::with(['course', 'student'])->findOrFail($id);
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment.
     */
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $courses = Course::orderBy('course_name')->get();
        $students = User::where('role_id', 3)->orderBy('full_name')->get();

        return view('enrollments.edit', compact('enrollment', 'courses', 'students'));
    }

    /**
     * Update the specified enrollment.
     */
    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'student_id' => 'required|exists:users,user_id',
        ]);

        // Check if already enrolled with different enrollment
        $exists = Enrollment::where('course_id', $request->course_id)
            ->where('student_id', $request->student_id)
            ->where('enrollment_id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Student is already enrolled in this course.')
                ->withInput();
        }

        $enrollment->update([
            'course_id' => $request->course_id,
            'student_id' => $request->student_id,
        ]);

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified enrollment.
     */
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        // Check permission (admin or teacher who created the course)
        $course = $enrollment->course;
        if (Auth::user()->role_id != 1 && $course->created_by != Auth::user()->user_id) {
            return redirect()->route('enrollments.index')
                ->with('error', 'You do not have permission to delete this enrollment.');
        }

        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment removed successfully.');
    }

    /**
     * Display student's enrolled courses.
     */
    public function myCourses()
    {
        $studentId = Auth::user()->user_id;

        $enrollments = Enrollment::with(['course.creator'])
            ->where('student_id', $studentId)
            ->get();

        return view('student.courses', compact('enrollments'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Grade;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role_id', 3)->count();
        $totalTeachers = User::where('role_id', 2)->count();
        $totalCourses = Course::count();
        $totalAssignments = Assignment::count();
        $totalSubmissions = Submission::count();
        $gradedSubmissions = Grade::count();
        $pendingGrading = $totalSubmissions - $gradedSubmissions;
        $averageScore = Grade::avg('marks_obtained') ?? 0;

        // Get submissions by course for chart
        $submissionsByCourse = DB::table('submissions')
            ->join('assignments', 'submissions.assignment_id', '=', 'assignments.assignment_id')
            ->join('courses', 'assignments.course_id', '=', 'courses.course_id')
            ->select('courses.course_name', DB::raw('COUNT(submissions.submission_id) as total'))
            ->groupBy('courses.course_id', 'courses.course_name')
            ->get();

        $courseLabels = $submissionsByCourse->pluck('course_name');
        $submissionData = $submissionsByCourse->pluck('total');

        if ($courseLabels->isEmpty()) {
            $courseLabels = collect(['No Data']);
            $submissionData = collect([0]);
        }

        // Grade distribution
        $grades = Grade::select('marks_obtained')->get();
        $gradeCounts = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'F' => 0];

        foreach ($grades as $grade) {
            if ($grade->marks_obtained >= 90) $gradeCounts['A']++;
            elseif ($grade->marks_obtained >= 80) $gradeCounts['B']++;
            elseif ($grade->marks_obtained >= 70) $gradeCounts['C']++;
            elseif ($grade->marks_obtained >= 60) $gradeCounts['D']++;
            else $gradeCounts['F']++;
        }

        $gradeLabels = collect(array_keys($gradeCounts));
        $gradeData = collect(array_values($gradeCounts));

        // Recent submissions with relationships
        $recentSubmissions = Submission::with(['student', 'assignment.course'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Upcoming deadlines with course relationship
        $upcomingDeadlines = Assignment::with('course')
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Unread notifications
        $unreadNotifications = Notification::where('user_id', Auth::user()->user_id ?? 0)
            ->where('is_read', false)
            ->count();

        return view('dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalCourses',
            'totalAssignments', 'totalSubmissions', 'gradedSubmissions',
            'pendingGrading', 'averageScore', 'courseLabels', 'submissionData',
            'gradeLabels', 'gradeData', 'recentSubmissions',
            'upcomingDeadlines', 'unreadNotifications'
        ));
    }

    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        $data = $this->getDashboardData();

        // Additional admin-specific data
        $data['totalUsers'] = User::count();
        $data['newUsersThisMonth'] = User::whereMonth('created_at', now()->month)->count();
        $data['recentUsers'] = User::with('role')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get chart data for admin dashboard
        $submissionsByCourse = DB::table('submissions')
            ->join('assignments', 'submissions.assignment_id', '=', 'assignments.assignment_id')
            ->join('courses', 'assignments.course_id', '=', 'courses.course_id')
            ->select('courses.course_name', DB::raw('COUNT(submissions.submission_id) as total'))
            ->groupBy('courses.course_id', 'courses.course_name')
            ->get();

        $data['courseLabels'] = $submissionsByCourse->pluck('course_name');
        $data['submissionData'] = $submissionsByCourse->pluck('total');

        if ($data['courseLabels']->isEmpty()) {
            $data['courseLabels'] = collect(['No Data']);
            $data['submissionData'] = collect([0]);
        }

        // Grade distribution for admin
        $grades = Grade::select('marks_obtained')->get();
        $gradeCounts = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'F' => 0];

        foreach ($grades as $grade) {
            if ($grade->marks_obtained >= 90) $gradeCounts['A']++;
            elseif ($grade->marks_obtained >= 80) $gradeCounts['B']++;
            elseif ($grade->marks_obtained >= 70) $gradeCounts['C']++;
            elseif ($grade->marks_obtained >= 60) $gradeCounts['D']++;
            else $gradeCounts['F']++;
        }

        $data['gradeLabels'] = collect(array_keys($gradeCounts));
        $data['gradeData'] = collect(array_values($gradeCounts));

        return view('admin.dashboard', $data);
    }

    /**
     * Teacher Dashboard
     */
    public function teacherDashboard()
    {
        $data = $this->getDashboardData();
        $data['myCourses'] = Course::where('created_by', Auth::user()->user_id)->get();
        $data['myAssignments'] = Assignment::where('created_by', Auth::user()->user_id)
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
        return view('teacher.dashboard', $data);
    }

    /**
     * Student Dashboard
     */
    public function studentDashboard()
    {
        $studentId = Auth::user()->user_id;

        // Get student's enrolled courses
        $myCourses = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.course_id')
            ->join('users', 'courses.created_by', '=', 'users.user_id')
            ->where('enrollments.student_id', $studentId)
            ->select('courses.*', 'users.full_name as teacher_name')
            ->get();

        // Get student's submissions with grades
        $mySubmissions = Submission::with(['assignment.course', 'grade'])
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get total stats for student
        $totalSubmissions = Submission::where('student_id', $studentId)->count();
        $pendingSubmissions = Submission::where('student_id', $studentId)
            ->whereDoesntHave('grade')
            ->count();
        $averageGrade = Grade::whereHas('submission', function($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->avg('marks_obtained') ?? 0;

        return view('student.dashboard', compact(
            'myCourses', 'mySubmissions', 'totalSubmissions',
            'pendingSubmissions', 'averageGrade'
        ));
    }

    /**
     * Get common dashboard data
     */
    private function getDashboardData()
    {
        return [
            'totalStudents' => User::where('role_id', 3)->count(),
            'totalTeachers' => User::where('role_id', 2)->count(),
            'totalCourses' => Course::count(),
            'totalAssignments' => Assignment::count(),
            'totalSubmissions' => Submission::count(),
            'gradedSubmissions' => Grade::count(),
            'pendingGrading' => Submission::count() - Grade::count(),
            'averageScore' => Grade::avg('marks_obtained') ?? 0,
            'recentSubmissions' => Submission::with(['student', 'assignment.course'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'upcomingDeadlines' => Assignment::with('course')
                ->where('due_date', '>=', now())
                ->orderBy('due_date', 'asc')
                ->limit(5)
                ->get(),
            'unreadNotifications' => Notification::where('user_id', Auth::user()->user_id ?? 0)
                ->where('is_read', false)
                ->count(),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function index()
    {
        $user = Auth::user();

        // Get user statistics based on role
        $stats = [];

        if ($user->role_id == 3) { // Student
            $stats['total_submissions'] = $user->submissions()->count();
            $stats['pending_grades'] = $user->submissions()->whereDoesntHave('grade')->count();
            $stats['average_grade'] = $user->grades()->avg('marks_obtained') ?? 0;
            $stats['enrolled_courses'] = $user->enrollments()->count();
        } elseif ($user->role_id == 2) { // Teacher
            $stats['total_courses'] = $user->createdCourses()->count();
            $stats['total_assignments'] = $user->createdAssignments()->count();
            $stats['total_submissions'] = 0; // Calculate through assignments
            foreach ($user->createdAssignments as $assignment) {
                $stats['total_submissions'] += $assignment->submissions()->count();
            }
        } else { // Admin
            $stats['total_users'] = User::count();
            $stats['total_courses'] = \App\Models\Course::count();
            $stats['total_assignments'] = \App\Models\Assignment::count();
            $stats['total_submissions'] = \App\Models\Submission::count();
        }

        return view('profile.index', compact('user', 'stats'));
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'username' => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Upload profile picture.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return redirect()->route('profile.index')
            ->with('success', 'Profile picture updated successfully.');
    }
}

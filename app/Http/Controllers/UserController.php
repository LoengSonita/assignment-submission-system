<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('role')->orderBy('user_id', 'desc')->paginate(10);
        $totalStudents = User::where('role_id', 3)->count();
        $totalTeachers = User::where('role_id', 2)->count();
        $totalAdmins = User::where('role_id', 1)->count();

        return view('admin.users.index', compact('users', 'totalStudents', 'totalTeachers', 'totalAdmins'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,role_id',
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:Active,Inactive'
        ]);

        User::create([
            'role_id' => $request->role_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->status
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role_id' => 'required|exists:roles,role_id',
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = [
            'role_id' => $request->role_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'status' => $request->status
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::check() && $user->user_id === Auth::user()->user_id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (Active/Inactive).
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->update(['status' => $newStatus]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User status updated successfully.');
    }
}

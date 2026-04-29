<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('department')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('staff_id', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'phone' => 'nullable|string|max:20',
            'staff_id' => 'nullable|string|max:50|unique:users,staff_id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'staff_id' => $request->staff_id,
        ]);

        $leaveTypes = LeaveType::all();

        foreach ($leaveTypes as $type) {
            LeaveBalance::create([
                'user_id' => $user->id,
                'leave_type_id' => $type->id,
                'year' => now()->year,
                'total_days' => $type->default_days,
                'used_days' => 0,
                'remaining_days' => $type->default_days,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Employee created successfully.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        return view('users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'phone' => 'nullable|string|max:20',
            'staff_id' => 'nullable|string|max:50|unique:users,staff_id,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'staff_id' => $request->staff_id,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Employee deleted successfully.');
    }
}
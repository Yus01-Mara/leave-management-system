<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::latest()->get();
        return view('leave_types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('leave_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:leave_types,name',
            'default_days' => 'required|integer|min:0',
            'requires_attachment' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        LeaveType::create([
            'name' => $request->name,
            'default_days' => $request->default_days,
            'requires_attachment' => $request->boolean('requires_attachment'),
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leave_types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required|unique:leave_types,name,' . $leaveType->id,
            'default_days' => 'required|integer|min:0',
            'requires_attachment' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $leaveType->update([
            'name' => $request->name,
            'default_days' => $request->default_days,
            'requires_attachment' => $request->boolean('requires_attachment'),
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()->route('leave-types.index')->with('success', 'Leave type deleted successfully.');
    }
}
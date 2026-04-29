<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['user', 'leaveType'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                              ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('leaveType', function ($typeQuery) use ($search) {
                    $typeQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('reason', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->get();

        return view('approvals.index', compact('leaveRequests'));
    }

    public function approve($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $balance = LeaveBalance::where('user_id', $leave->user_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->where('year', now()->year)
            ->first();

        if (!$balance || $balance->remaining_days < $leave->total_days) {
            return back()->with('error', 'Not enough leave balance.');
        }

        $balance->used_days += $leave->total_days;
        $balance->remaining_days = $balance->total_days - $balance->used_days;
        $balance->save();

        $leave->status = 'approved';
        $leave->approved_by = Auth::id();
        $leave->approved_at = now();
        $leave->save();

        return back()->with('success', 'Leave approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $leave->status = 'rejected';
        $leave->admin_remark = $request->admin_remark;
        $leave->approved_by = Auth::id();
        $leave->approved_at = now();
        $leave->save();

        return back()->with('success', 'Leave rejected successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenolongPengarahApprovalController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'penolong_pengarah') {
            abort(403);
        }

        $leaveRequests = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', 'approved_by_ketua_pegawai')
            ->latest()
            ->get();

        return view('penolong_approvals.index', compact('leaveRequests'));
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'penolong_pengarah') {
            abort(403);
        }

        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'approved_by_ketua_pegawai') {
            return back()->with('error', 'Already processed.');
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

        $leave->update([
            'penolong_pengarah_id' => Auth::id(),
            'penolong_pengarah_status' => 'approved',
            'penolong_pengarah_approved_at' => now(),
            'status' => 'approved',
        ]);

        return back()->with('success', 'Final approval completed.');
    }

    public function reject(Request $request, $id)
    {
        if (auth()->user()->role !== 'penolong_pengarah') {
            abort(403);
        }

        $request->validate([
            'remark' => 'required|string|max:255',
        ]);

        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'approved_by_ketua_pegawai') {
            return back()->with('error', 'Already processed.');
        }

        $leave->update([
            'penolong_pengarah_id' => Auth::id(),
            'penolong_pengarah_status' => 'rejected',
            'penolong_pengarah_remark' => $request->remark,
            'penolong_pengarah_approved_at' => now(),
            'status' => 'rejected_by_penolong_pengarah',
        ]);

        return back()->with('success', 'Rejected by Penolong Pengarah.');
    }
}
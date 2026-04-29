<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KetuaPegawaiApprovalController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', 'pending_ketua_pegawai')
            ->latest()
            ->get();

        return view('ketua_approvals.index', compact('leaveRequests'));
    }

    public function approve($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending_ketua_pegawai') {
            return back()->with('error', 'Already processed.');
        }

        $leave->update([
            'ketua_pegawai_id' => Auth::id(),
            'ketua_pegawai_status' => 'approved',
            'ketua_pegawai_approved_at' => now(),
            'status' => 'approved_by_ketua_pegawai',
        ]);

        return back()->with('success', 'Approved by Ketua Pegawai.');
    }

    public function reject(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'ketua_pegawai_id' => Auth::id(),
            'ketua_pegawai_status' => 'rejected',
            'ketua_pegawai_remark' => $request->remark,
            'ketua_pegawai_approved_at' => now(),
            'status' => 'rejected_by_ketua_pegawai',
        ]);

        return back()->with('success', 'Rejected by Ketua Pegawai.');
    }
}
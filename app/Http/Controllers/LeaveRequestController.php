<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with('leaveType')
            ->where('user_id', Auth::id())
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('leaveType', function ($typeQuery) use ($search) {
                    $typeQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('reason', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->get();

        return view('leave_requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::where('status', 1)->get();
        return view('leave_requests.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $totalDays = $start->diffInDays($end) + 1;

        $balance = LeaveBalance::where('user_id', Auth::id())
            ->where('leave_type_id', $request->leave_type_id)
            ->where('year', now()->year)
            ->first();

        if (!$balance || $balance->remaining_days < $totalDays) {
            return back()->withErrors(['error' => 'Insufficient leave balance.'])->withInput();
        }

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        LeaveRequest::create([
            'user_id' => Auth::id(),
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request submitted successfully.');
    }
}
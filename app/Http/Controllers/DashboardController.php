<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = User::where('role', 'employee')->count();
        $totalRequests = LeaveRequest::count();
        $pendingRequests = LeaveRequest::where('status', 'pending_ketua_pegawai')->count();
        $approvedRequests = LeaveRequest::where('status', 'approved')->count();
        $rejectedRequests = LeaveRequest::where('status', 'rejected')->count();
        $totalDepartments = Department::count();

        $chartData = [
            'pending' => $pendingRequests,
            'approved' => $approvedRequests,
            'rejected' => $rejectedRequests,
        ];

        return view('dashboard', compact(
            'totalEmployees',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'totalDepartments',
            'chartData'
        ));
    }
}
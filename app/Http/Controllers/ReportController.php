<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function leaveReport()
    {
        $leaveRequests = LeaveRequest::with(['user', 'leaveType'])->latest()->get();

        $pdf = Pdf::loadView('reports.leave_report', compact('leaveRequests'));

        return $pdf->download('leave-report.pdf');
    }
}
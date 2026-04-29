@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Leave Approvals</h3>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('approvals.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" name="search" class="form-control rounded-3"
                               placeholder="Search employee, leave type, or reason"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4 mb-2 mb-md-0">
                        <select name="status" class="form-select rounded-3">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-dark rounded-3">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Total Days</th>
                            <th>Reason</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests as $leave)
                            <tr>
                                <td>{{ $leave->id }}</td>
                                <td>{{ $leave->user->name ?? '-' }}</td>
                                <td>{{ $leave->leaveType->name ?? '-' }}</td>
                                <td>{{ $leave->start_date }}</td>
                                <td>{{ $leave->end_date }}</td>
                                <td>{{ $leave->total_days }}</td>
                                <td>{{ $leave->reason }}</td>
                                <td>
                                    @if($leave->attachment)
                                        <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="btn btn-sm btn-info rounded-3">
                                            View
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($leave->status == 'pending')
                                        <form action="{{ route('approvals.approve', $leave->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3">Approve</button>
                                        </form>

                                        <form action="{{ route('approvals.reject', $leave->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="text" name="admin_remark" class="form-control form-control-sm d-inline-block w-auto rounded-3" placeholder="Reject reason">
                                            <button type="submit" class="btn btn-sm btn-danger rounded-3">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-secondary">Done</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-secondary">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
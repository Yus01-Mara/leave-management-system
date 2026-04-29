@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">My Leave Requests</h3>
        <a href="{{ route('leave-requests.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Apply Leave
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('leave-requests.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" name="search" class="form-control rounded-3"
                               placeholder="Search leave type or reason"
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
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th>Reason</th>
                            <th>Attachment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->leaveType->name ?? '-' }}</td>
                                <td>{{ $request->start_date }}</td>
                                <td>{{ $request->end_date }}</td>
                                <td>{{ $request->total_days }}</td>
                                <td>{{ $request->reason }}</td>
                                <td>
                                    @if($request->attachment)
                                        <a href="{{ asset('storage/' . $request->attachment) }}" target="_blank" class="btn btn-sm btn-info rounded-3">
                                            View
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'pending_ketua_pegawai' => ['label' => 'Pending Ketua Pegawai', 'color' => 'warning'],
                                            'approved_by_ketua_pegawai' => ['label' => 'Approved by Ketua (Waiting Final)', 'color' => 'info'],
                                            'approved' => ['label' => 'Approved', 'color' => 'success'],
                                            'rejected_by_ketua_pegawai' => ['label' => 'Rejected by Ketua Pegawai', 'color' => 'danger'],
                                            'rejected_by_penolong_pengarah' => ['label' => 'Rejected by Penolong Pengarah', 'color' => 'danger'],
                                        ];

                                        $status = $statusMap[$request->status] ?? ['label' => ucfirst($request->status), 'color' => 'secondary'];
                                    @endphp

                                    <span class="badge bg-{{ $status['color'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-secondary">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
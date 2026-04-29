@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Penolong Pengarah Approvals</h3>

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
                            <th>Ketua Status</th>
                            <th class="text-center">Final Action</th>
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
                                    <span class="badge bg-success">
                                        Approved by Ketua Pegawai
                                    </span>
                                </td>

                                <td class="text-center">
                                    <form action="{{ route('penolong.approve', $leave->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-3">
                                            Final Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('penolong.reject', $leave->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="text" name="remark" class="form-control form-control-sm d-inline-block w-auto rounded-3" placeholder="Reject reason">
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-secondary">
                                    No requests waiting for Penolong Pengarah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
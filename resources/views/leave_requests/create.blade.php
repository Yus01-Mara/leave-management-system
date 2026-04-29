@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Apply Leave</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('leave-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Leave Type</label>
                    <select name="leave_type_id" class="form-select rounded-3">
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="start_date" class="form-control rounded-3">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">End Date</label>
                    <input type="date" name="end_date" class="form-control rounded-3">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Reason</label>
                    <textarea name="reason" class="form-control rounded-3" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Attachment (MC / PDF / Image)</label>
                    <input type="file" name="attachment" class="form-control rounded-3">
                </div>

                <button type="submit" class="btn btn-success rounded-3">Submit</button>
                <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
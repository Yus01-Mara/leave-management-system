@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Add Leave Type</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('leave-types.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Leave Type Name</label>
                    <input type="text" name="name" class="form-control rounded-3">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Default Days</label>
                    <input type="number" name="default_days" class="form-control rounded-3">
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="requires_attachment" value="1" class="form-check-input" id="requires_attachment">
                    <label class="form-check-label" for="requires_attachment">Requires Attachment</label>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="status" value="1" class="form-check-input" id="status" checked>
                    <label class="form-check-label" for="status">Active</label>
                </div>

                <button type="submit" class="btn btn-success rounded-3">Save</button>
                <a href="{{ route('leave-types.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
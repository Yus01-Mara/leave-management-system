@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Add Department</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Department Name</label>
                    <input type="text" name="name" class="form-control rounded-3">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control rounded-3" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-success rounded-3">
                    <i class="bi bi-check-circle me-1"></i> Save
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
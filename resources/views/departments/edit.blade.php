@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Edit Department</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Department Name</label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ $department->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control rounded-3" rows="4">{{ $department->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary rounded-3">
                    <i class="bi bi-save me-1"></i> Update
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
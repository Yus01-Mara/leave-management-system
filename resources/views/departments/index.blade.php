@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Departments</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Add Department
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr>
                                <td>{{ $department->id }}</td>
                                <td class="fw-semibold">{{ $department->name }}</td>
                                <td>{{ $department->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-warning rounded-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Delete this department?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary">No departments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
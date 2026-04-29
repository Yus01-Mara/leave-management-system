@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Leave Types</h3>
        <a href="{{ route('leave-types.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Add Leave Type
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
                            <th>Default Days</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td class="fw-semibold">{{ $type->name }}</td>
                                <td>{{ $type->default_days }}</td>
                                <td>
                                    <span class="badge bg-{{ $type->requires_attachment ? 'warning' : 'secondary' }}">
                                        {{ $type->requires_attachment ? 'Required' : 'Not Required' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $type->status ? 'success' : 'danger' }}">
                                        {{ $type->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('leave-types.edit', $type->id) }}" class="btn btn-sm btn-warning rounded-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('leave-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Delete this leave type?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary">No leave types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Employees</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Add Employee
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row">
                    <div class="col-md-10 mb-2 mb-md-0">
                        <input type="text" name="search" class="form-control rounded-3"
                               placeholder="Search by name, email, staff ID, or phone"
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-dark rounded-3">Search</button>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Phone</th>
                            <th>Staff ID</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'dark' : 'primary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->department->name ?? '-' }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>{{ $user->staff_id ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning rounded-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Delete this employee?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-secondary">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
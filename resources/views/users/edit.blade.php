@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Edit Employee</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ $user->name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ $user->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Leave blank if unchanged">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select rounded-3">
                            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Department</label>
                        <select name="department_id" class="form-select rounded-3">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ $user->phone }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Staff ID</label>
                        <input type="text" name="staff_id" class="form-control rounded-3" value="{{ $user->staff_id }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary rounded-3">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
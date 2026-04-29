@extends('layouts.app')

@section('content')
    <h3 class="fw-bold mb-4">Add Employee</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control rounded-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control rounded-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select rounded-3">
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                            <option value="ketua_pegawai">Ketua Pegawai</option>
                            <option value="penolong_pengarah">Penolong Pengarah</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Department</label>
                        <select name="department_id" class="form-select rounded-3">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control rounded-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Staff ID</label>
                        <input type="text" name="staff_id" class="form-control rounded-3">
                    </div>
                </div>

                <button type="submit" class="btn btn-success rounded-3">Save</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-3">Back</a>
            </form>
        </div>
    </div>
@endsection
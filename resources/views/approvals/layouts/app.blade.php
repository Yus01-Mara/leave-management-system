<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #212529;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 16px;
        }

        .sidebar a:hover {
            background: #343a40;
        }

        .content {
            padding: 20px;
        }

        .card-box {
            border-radius: 12px;
            color: white;
            padding: 20px;
        }

        .bg-blue { background: #0d6efd; }
        .bg-green { background: #198754; }
        .bg-orange { background: #fd7e14; }
        .bg-red { background: #dc3545; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <h4 class="text-white text-center py-3 border-bottom">LMS</h4>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('departments.index') }}">Departments</a>
            <a href="{{ route('leave-types.index') }}">Leave Types</a>
            <a href="{{ route('leave-requests.index') }}">My Leave Requests</a>
            <a href="{{ route('leave-requests.create') }}">Apply Leave</a>
            <a href="{{ route('approvals.index') }}">Approvals</a>
        </div>

        <div class="col-md-10">
            <nav class="navbar navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Leave Management System</span>
                </div>
            </nav>

            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>

</body>
</html>
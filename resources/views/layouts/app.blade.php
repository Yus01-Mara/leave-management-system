<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: #fff;
            transition: width 0.3s ease;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            height: 70px;
            padding: 0 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-text {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .toggle-btn {
            border: none;
            background: rgba(255,255,255,0.12);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            transition: 0.2s ease;
        }

        .toggle-btn:hover {
            background: rgba(255,255,255,0.22);
        }

        .menu-section {
            padding: 14px 12px;
        }

        .menu-label {
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            padding: 10px 12px 6px;
            letter-spacing: 1px;
        }

        .sidebar.collapsed .menu-label,
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .user-box .user-details {
            display: none;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.88);
            text-decoration: none;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 12px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .menu-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .menu-link.active {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.28);
        }

        .menu-icon {
            font-size: 18px;
            min-width: 24px;
            text-align: center;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 12px 10px;
        }

        .main {
            flex: 1;
            transition: all 0.3s ease;
        }

        .topbar {
            height: 70px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 0 24px;
        }

        .page-content {
            padding: 24px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }

        .topbar-subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .user-box {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 14px 12px;
            margin-top: auto;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255,255,255,0.06);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #2563eb;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255,255,255,0.65);
            margin: 0;
        }

        .logout-btn {
            width: 100%;
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            padding: 10px 12px;
            background: rgba(220,53,69,0.15);
            color: #fff;
            transition: 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(220,53,69,0.28);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .brand-text,
            .menu-text,
            .menu-label,
            .user-details {
                display: none !important;
            }

            .menu-link {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <aside id="sidebar" class="sidebar d-flex flex-column">
        <div class="sidebar-header d-flex align-items-center justify-content-between">
            <span class="brand-text">LMS</span>
            <button id="menu-toggle" class="toggle-btn" type="button">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="menu-section">
            <div class="menu-label">Main Menu</div>

            <a href="{{ route('dashboard') }}"
               class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('leave-requests.index') }}"
               class="menu-link {{ request()->routeIs('leave-requests.index') ? 'active' : '' }}">
                <i class="bi bi-journal-text menu-icon"></i>
                <span class="menu-text">My Leave</span>
            </a>

            <a href="{{ route('leave-requests.create') }}"
               class="menu-link {{ request()->routeIs('leave-requests.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle menu-icon"></i>
                <span class="menu-text">Apply Leave</span>
            </a>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="menu-label">Administration</div>

                <a href="{{ route('users.index') }}"
                   class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people menu-icon"></i>
                    <span class="menu-text">Employees</span>
                </a>

                <a href="{{ route('departments.index') }}"
                   class="menu-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3 menu-icon"></i>
                    <span class="menu-text">Departments</span>
                </a>

                <a href="{{ route('leave-types.index') }}"
                   class="menu-link {{ request()->routeIs('leave-types.*') ? 'active' : '' }}">
                    <i class="bi bi-tags menu-icon"></i>
                    <span class="menu-text">Leave Types</span>
                </a>

                <a href="{{ route('approvals.index') }}"
                   class="menu-link {{ request()->routeIs('approvals.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-square menu-icon"></i>
                    <span class="menu-text">Approvals</span>
                </a>

                <a href="{{ route('reports.leave') }}"
                    class="menu-link {{ request()->routeIs('reports.leave') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf menu-icon"></i>
                        <span class="menu-text">PDF Report</span>
                </a>
            @endif
        </div>

        @auth
        <div class="user-box">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <p class="user-name">{{ auth()->user()->name }}</p>
                    <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <main class="main">
        <nav class="topbar d-flex align-items-center justify-content-between">
            <div>
                <div class="page-title">Leave Management System</div>
                <div class="topbar-subtitle">Employee leave administration dashboard</div>
            </div>
        </nav>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    });
</script>

</body>
</html>
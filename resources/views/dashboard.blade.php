@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Employees</div>
                            <h2 class="fw-bold mb-0">{{ $totalEmployees }}</h2>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Requests</div>
                            <h2 class="fw-bold mb-0">{{ $totalRequests }}</h2>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Pending Requests</div>
                            <h2 class="fw-bold mb-0">{{ $pendingRequests }}</h2>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Departments</div>
                            <h2 class="fw-bold mb-0">{{ $totalDepartments }}</h2>
                        </div>
                        <div class="fs-1 text-dark">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Leave Request Status</h5>
                    <canvas id="leaveChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Quick Summary</h5>

                    <div class="mb-3 d-flex justify-content-between">
                        <span>Approved</span>
                        <span class="badge bg-success">{{ $approvedRequests }}</span>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <span>Rejected</span>
                        <span class="badge bg-danger">{{ $rejectedRequests }}</span>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <span>Pending</span>
                        <span class="badge bg-warning text-dark">{{ $pendingRequests }}</span>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('leave-requests.create') }}" class="btn btn-primary rounded-3">
                            Apply Leave
                        </a>

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('approvals.index') }}" class="btn btn-outline-dark rounded-3">
                                View Approvals
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('leaveChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Rejected'],
                datasets: [{
                    label: 'Requests',
                    data: [
                        {{ $chartData['pending'] }},
                        {{ $chartData['approved'] }},
                        {{ $chartData['rejected'] }}
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Leave Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Leave Management Report</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Days</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaveRequests as $leave)
                <tr>
                    <td>{{ $leave->id }}</td>
                    <td>{{ $leave->user->name ?? '-' }}</td>
                    <td>{{ $leave->leaveType->name ?? '-' }}</td>
                    <td>{{ $leave->start_date }}</td>
                    <td>{{ $leave->end_date }}</td>
                    <td>{{ $leave->total_days }}</td>
                    <td>{{ ucfirst($leave->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
    <title>Appointment Details</title>
</head>

<body>
    <h1>Your Appointment Details</h1>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <tr>
            <th>Service</th>
            <th>Appointment Time</th>
            <th>Assigned Employee</th>
        </tr>
        <tr>
            <td>{{ $booking->service->name }}</td>
            <td>{{ $booking->appointment_time }}</td>
            <td>{{ $booking->employee->name ?? 'Not Assigned' }}</td>
        </tr>
    </table>

    <a href="/">Back to Home</a>
</body>

</html>
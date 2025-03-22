@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Your Appointment Details</h1>

    @if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-lg rounded">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Service</th>
                        <th>Appointment Time</th>
                        <th>Assigned Employee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $booking->service->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->appointment_time)->format('F j, Y, g:i A') }}</td>
                        <td>{{ $booking->employee->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="/" class="btn btn-primary">Back to Home</a>
    </div>
</div>

@endsection
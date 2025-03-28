@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Welcome, {{ Auth::user()->name }}!</h2>
    <p>Here you can manage your bookings and payments.</p>

    <div class="row">
        <!-- Appointments Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Your Appointments</div>
                <div class="card-body">
                    @if($appointments->isEmpty())
                    <p>You have no upcoming appointments.</p>
                    @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->service->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('F j, Y, g:i A') }}</td>
                                <td>{{ ucfirst($appointment->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <a href="{{ url('/book') }}" class="btn btn-sm btn-primary mt-3">Book New Appointment</a>
                </div>
            </div>
        </div>

        <!-- Payment History Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">Payment History</div>

            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('reviews.index') }}" class="btn btn-warning">Give a Review</a>
    </div>
</div>
@endsection
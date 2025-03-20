@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Welcome, {{ Auth::user()->name }}!</h2>
    <p>Here you can manage your bookings and payments.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Your Appointments</div>
                <div class="card-body">
                    <h2>Your Appointments</h2>
                    @if($appointments->isEmpty())
                    <p>You have no upcoming appointments.</p>
                    @else
                    <table class="table">
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
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <a href="{{ route('book.create') }}" class="btn btn-sm btn-primary">Book New Appointment</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">Payment History</div>
                <div class="card-body">
                    <p>Your last payment was <strong>KES 3,000</strong> on <strong>March 15, 2024</strong>.</p>
                    <a href="{{ route('mpesa.payment') }}" class="btn btn-sm btn-success">Make Payment</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('reviews.index') }}" class="btn btn-warning">Give a Review</a>
    </div>
</div>
@endsection
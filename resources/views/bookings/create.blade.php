@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg rounded w-100" style="max-width: 900px;">
        <div class="row g-0">
            <!-- Left Column: Image -->
            <div class="col-md-6">
                <img src="{{ asset('images/salon.jpg') }}" alt="Salon Image" class="img-fluid rounded-start">
            </div>

            <!-- Right Column: Booking Form -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="p-4 w-100">
                    <h1 class="text-center mb-4">Book an Appointment</h1>

                    <form method="POST" action="{{ route('book.create') }}">
                        @csrf

                        <!-- Service Selection -->
                        <div class="form-group">
                            <label for="service">Select a Service</label>
                            <select name="service_id" id="service" class="form-control" required>
                                <option value="">-- Select a Service --</option>
                                @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Appointment Time -->
                        <div class="form-group mt-3">
                            <label for="appointment_time">Appointment Time</label>
                            <input type="datetime-local" name="appointment_time" id="appointment_time" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
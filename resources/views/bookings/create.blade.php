@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book an Appointment</h1>
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
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </div>
    </form>
</div>
@endsection
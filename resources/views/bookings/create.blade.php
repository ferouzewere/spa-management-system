@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Book an Appointment</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="service_id" class="form-label">Service</label>
                            <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                <option value="">Select a service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Appointment Date & Time</label>
                            <input type="datetime-local" class="form-control @error('appointment_time') is-invalid @enderror" 
                                   id="appointment_time" name="appointment_time" 
                                   value="{{ old('appointment_time') }}"
                                   min="{{ date('Y-m-d\TH:i') }}"
                                   required>
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }}!</h2>
    <p>Manage your work schedule and client appointments.</p>

    <div class="row">
        <!-- Today's Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Today's Appointments</h5>
                </div>
                <div class="card-body">
                    @if($todaysAppointments->isEmpty())
                    <p>No appointments scheduled for today.</p>
                    @else
                    <ul class="list-group">
                        @foreach($todaysAppointments as $appointment)
                        <li class="list-group-item">
                            {{ $appointment->time }} - {{ $appointment->client->name }} ({{ $appointment->service->name }})
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    <a href="{{ route('appointments.manage') }}" class="btn btn-info btn-sm mt-2">View All Appointments</a>
                </div>
            </div>
        </div>

        <!-- Work Schedule -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5>Work Schedule</h5>
                </div>
                <div class="card-body">
                    <p>You are scheduled to work from <strong>8:00 AM - 5:00 PM</strong>.</p>
                    <p><strong>Next Day Off:</strong> Sunday</p>
                    <a href="#" class="btn btn-sm btn-warning">View Full Schedule</a>
                    <p>Your work schedule: <strong>{{ $work_schedule ?? 'Not set' }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Client Requests -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Pending Client Requests</h5>
                </div>
                <div class="card-body">
                    @if($clientRequests->isEmpty())
                    <p>No pending client requests.</p>
                    @else
                    <ul class="list-group">
                        @foreach($clientRequests as $request)
                        <li class="list-group-item">{{ $request->description }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <a href="#" class="btn btn-primary btn-sm mt-2">Respond to Requests</a>
                </div>
            </div>
        </div>

        <!-- Update Availability -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Update Availability</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee.updateAvailability') }}" method="POST">
                        @csrf
                        <label for="availability">Set Your Availability:</label>
                        <select name="availability" id="availability" class="form-control">
                            <option value="available" {{ $employee->availability == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="busy" {{ $employee->availability == 'busy' ? 'selected' : '' }}>Busy</option>
                            <option value="off-duty" {{ $employee->availability == 'off-duty' ? 'selected' : '' }}>Off Duty</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success mt-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
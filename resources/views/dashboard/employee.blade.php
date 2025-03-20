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
                    <ul class="list-group">
                        <li class="list-group-item">9:00 AM - Client A (Haircut)</li>
                        <li class="list-group-item">11:00 AM - Client B (Facial Treatment)</li>
                        <li class="list-group-item">1:00 PM - Client C (Manicure & Pedicure)</li>
                    </ul>
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
                    <ul class="list-group">
                        <li class="list-group-item">Client X requested an urgent reschedule</li>
                        <li class="list-group-item">Client Y wants a home service</li>
                    </ul>
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
                            <option value="available">Available</option>
                            <option value="busy">Busy</option>
                            <option value="off-duty">Off Duty</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success mt-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
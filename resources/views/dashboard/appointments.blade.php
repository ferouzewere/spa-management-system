<div class="card">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <span>Your Appointments</span>
        <a href="{{ route('bookings.create') }}" class="btn btn-light btn-sm">Book New Appointment</a>
    </div>
    <div class="card-body">
        @if($appointments->isEmpty())
        <p class="text-muted">No appointments found.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Service</th>
                        <th>Employee</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M d, Y h:i A') }}</td>
                        <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->employee->user->name ?? 'To be assigned' }}</td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 
                                ($appointment->status === 'pending' ? 'warning' : 
                                ($appointment->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
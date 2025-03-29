<div class="card">
    <div class="card-header bg-primary text-white">Your Appointments</div>
    <div class="card-body">
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Booking Confirmed!',
                    html: `
                    <strong>Service:</strong> {{ session('booking')->service->name }}<br>
                    <strong>Appointment Time:</strong> {{ \Carbon\Carbon::parse(session('booking')->appointment_time)->format('F j, Y, g:i A') }}<br>
                    <strong>Assigned Employee:</strong> {{ session('booking')->employee->name ?? 'Not Assigned' }}
                `,
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: false
                });
            });
        </script>
        @endif

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
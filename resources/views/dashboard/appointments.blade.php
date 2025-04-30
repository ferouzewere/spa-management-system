<div class="bg-white shadow-md rounded my-6">
    <div class="px-6 py-4 bg-gray-200 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-600">Your Appointments</h2>
        <a href="{{ route('bookings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Book New Appointment</a>
    </div>
    <div class="p-6">
        @if($appointments->isEmpty())
        <p class="text-gray-500">No appointments found.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Date & Time</th>
                        <th class="py-3 px-6 text-left">Service</th>
                        <th class="py-3 px-6 text-left">Employee</th>
                        <th class="py-3 px-6 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach($appointments as $appointment)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M d, Y h:i A') }}</td>
                        <td class="py-3 px-6 text-left">{{ $appointment->service->name ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-left">{{ $appointment->employee->user->name ?? 'To be assigned' }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $appointment->status === 'confirmed' ? 'bg-green-200 text-green-800' : ($appointment->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
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
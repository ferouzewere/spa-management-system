<div class="bg-white shadow-md rounded my-6">
    <div class="px-6 py-4 bg-gray-200 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-600">Payment History</h2>
    </div>
    <div class="p-6">
        @if($payments->isEmpty())
        <p class="text-gray-500">No payment history found.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Amount</th>
                        <th class="py-3 px-6 text-left">Service</th>
                        <th class="py-3 px-6 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach($payments as $payment)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $payment->created_at->format('M d, Y') }}</td>
                        <td class="py-3 px-6 text-left">Ksh {{ number_format($payment->amount, 2) }}</td>
                        <td class="py-3 px-6 text-left">{{ $payment->service->name ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $payment->status === 'paid' ? 'bg-green-200 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div class="mt-6">
            <a href="{{ route('mpesa.payment') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Make a Payment</a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
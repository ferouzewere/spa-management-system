<div class="card">
    <div class="card-header bg-success text-white">Payment History</div>
    <div class="card-body">
        @if($payments->isEmpty())
        <p class="text-muted">No payment history found.</p>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->service->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <a href="{{ url('/make-payment') }}" class="btn btn-success mt-3">Make a Payment</a>
    </div>
</div>
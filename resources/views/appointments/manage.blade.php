@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Appointments</h2>
    @if($appointments->isEmpty())
        <p>No appointments assigned to you.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->user->name }}</td>
                    <td>{{ $appointment->service->name }}</td>
                    <td>{{ $appointment->date }}</td>
                    <td>{{ $appointment->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

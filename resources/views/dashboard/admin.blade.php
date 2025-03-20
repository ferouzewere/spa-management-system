@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, Admin {{ Auth::user()->name }}!</h2>
    <p>Manage salon operations efficiently.</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Bookings</div>
                <div class="card-body">
                    <p>There are <strong>20</strong> pending bookings.</p>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-primary">Manage Bookings</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">Employees</div>
                <div class="card-body">
                    <p>Total Employees: <strong>10</strong></p>
                    <a href="{{ route('admin.employees') }}" class="btn btn-sm btn-success">Manage Employees</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-dark">Financial Reports</div>
                <div class="card-body">
                    <p>Last month’s revenue: <strong>KES 250,000</strong></p>
                    <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-warning">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
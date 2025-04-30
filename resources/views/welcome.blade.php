@extends('layouts.app')

@section('content')
<div class="position-relative w-100 min-vh-100 overflow-hidden m-0">
    <img src="{{ asset('images/image1.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Salon Image">

    <!-- Blur/Tint Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

    <!-- Overlay Content -->
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
        <h1 class="fw-bold display-4">Welcome to Our Salon & Spa</h1>
        <p class="fs-4">Experience luxury and relaxation with our professional beauty services.</p>

        @if(Auth::check())
        <a href="{{ route('bookings.create') }}" class="btn btn-lg btn-primary m-2">Book an Appointment</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-lg btn-primary m-2">Login to Book</a>
        @endif
    </div>
</div>
@endsection
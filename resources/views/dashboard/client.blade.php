@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group sticky-top">
                <a href="#" class="list-group-item list-group-item-action active" data-tab="appointments">
                    <i class="fas fa-calendar-alt"></i> Appointments
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-tab="payments">
                    <i class="fas fa-wallet"></i> Payments
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-tab="reviews">
                    <i class="fas fa-star"></i> Reviews
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-tab="notifications">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-tab="settings">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <div id="dashboard-content">
                <!-- Default Content (Appointments) -->
                @include('dashboard.appointments')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.list-group-item');
        const contentArea = document.getElementById('dashboard-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Fetch and load the content dynamically
                const tabName = this.getAttribute('data-tab');
                fetch(`/dashboard/${tabName}`)
                    .then(response => response.text())
                    .then(html => {
                        contentArea.innerHTML = html;
                    })
                    .catch(error => console.error('Error loading tab content:', error));
            });
        });
    });
</script>
@endpush
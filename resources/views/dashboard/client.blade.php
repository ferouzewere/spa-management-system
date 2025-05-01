@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white">
        <div class="px-4 py-8 sticky top-0">
            <h2 class="text-xl font-bold mb-8">Welcome, {{ Auth::user()->name }}!</h2>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="#" id="sidebar-appointments" class="block py-3 px-4 rounded hover:bg-gray-700 client-sidebar">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="sidebar-payments" class="block py-3 px-4 rounded hover:bg-gray-700 client-sidebar">
                            <i class="fas fa-wallet mr-3"></i>
                            <span>Payments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="sidebar-reviews" class="block py-3 px-4 rounded hover:bg-gray-700 client-sidebar">
                            <i class="fas fa-star mr-3"></i>
                            <span>Reviews</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="sidebar-notifications" class="block py-3 px-4 rounded hover:bg-gray-700 client-sidebar">
                            <i class="fas fa-bell mr-3"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="sidebar-settings" class="block py-3 px-4 rounded hover:bg-gray-700 client-sidebar">
                            <i class="fas fa-cog mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <form action="{{ route('logout') }}" method="POST" class="mt-8">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100">
        <div class="p-8">
            <!-- Appointments Section -->
            <div id="section-appointments" class="client-section">
                {!! $appointmentsData !!}
            </div>

            <!-- Payments Section -->
            <div id="section-payments" class="client-section hidden">
                {!! $paymentsData !!}
            </div>

            <!-- Reviews Section -->
            <div id="section-reviews" class="client-section hidden">
                {!! $reviewsData !!}
            </div>

            <!-- Notifications Section -->
            <div id="section-notifications" class="client-section hidden">
                <div class="bg-white shadow-md rounded my-6">
                    <div class="px-6 py-4 bg-gray-200 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-600">Notifications</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-500">No new notifications.</p>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div id="section-settings" class="client-section hidden">
                <div class="bg-white shadow-md rounded my-6">
                    <div class="px-6 py-4 bg-gray-200 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-600">Settings</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-500">Account settings and preferences will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.client-section');
        const sidebarLinks = [{
                btn: 'sidebar-appointments',
                section: 'section-appointments'
            },
            {
                btn: 'sidebar-payments',
                section: 'section-payments'
            },
            {
                btn: 'sidebar-reviews',
                section: 'section-reviews'
            },
            {
                btn: 'sidebar-notifications',
                section: 'section-notifications'
            },
            {
                btn: 'sidebar-settings',
                section: 'section-settings'
            }
        ];

        // Set initial active section
        document.getElementById('section-appointments').classList.remove('hidden');
        document.getElementById('sidebar-appointments').classList.add('bg-gray-700');

        // Add click handlers to sidebar links
        sidebarLinks.forEach(link => {
            document.getElementById(link.btn).addEventListener('click', function(e) {
                e.preventDefault();

                // Update active states
                document.querySelectorAll('.client-sidebar').forEach(el => el.classList.remove('bg-gray-700'));
                this.classList.add('bg-gray-700');

                // Show active section
                sections.forEach(section => section.classList.add('hidden'));
                document.getElementById(link.section).classList.remove('hidden');
            });
        });

        // Handle flash messages
        const messages = {
            success: '{!! Session::has("success") ? Session::get("success") : "" !!}',
            error: '{!! Session::has("error") ? Session::get("error") : "" !!}'
        };

        if (messages.success) {
            showToast(messages.success, 'success');
        }

        if (messages.error) {
            showToast(messages.error, 'error');
        }
    });
</script>
@endpush
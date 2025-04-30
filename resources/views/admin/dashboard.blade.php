@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col py-8 px-4 min-h-screen">
        <nav class="flex-1">
            <ul class="space-y-4">
                <li><a href="#" id="sidebar-dashboard" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a></li>
                <li><a href="#" id="sidebar-users" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Users</a></li>
                <li><a href="#" id="sidebar-services" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Services</a></li>
                <li><a href="#" id="sidebar-employees" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Employees</a></li>
                <li><a href="#" id="sidebar-appointments" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Appointments</a></li>
                <li><a href="#" id="sidebar-bookings" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Bookings</a></li>
                <li><a href="#" id="sidebar-payments" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Payments</a></li>
                <li><a href="#" id="sidebar-reviews" class="block py-2 px-3 rounded hover:bg-gray-700">Manage Reviews</a></li>
                <li><a href="#" id="sidebar-notifications" class="block py-2 px-3 rounded hover:bg-gray-700">Notifications</a></li>
                <li><a href="#" id="sidebar-settings" class="block py-2 px-3 rounded hover:bg-gray-700">Settings</a></li>
            </ul>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 px-8 py-8">
        <div id="section-dashboard" class="admin-section">
            <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sales/Collection -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center">
                    <div class="text-gray-500 text-sm mb-2">Total Collection</div>
                    <div class="text-2xl font-bold text-green-600">Ksh {{ number_format($totalSales ?? 0) }}</div>
                </div>
                <!-- Total Customers -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center">
                    <div class="text-gray-500 text-sm mb-2">Total Customers</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $totalCustomers ?? 0 }}</div>
                </div>
                <!-- Appointments Completed / Total -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center">
                    <div class="text-gray-500 text-sm mb-2">Appointments Completed</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $completedAppointments ?? 0 }} / {{ $totalAppointments ?? 0 }}</div>
                </div>
                <!-- Workers Busy / Free -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center">
                    <div class="text-gray-500 text-sm mb-2">Workers Busy / Free</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $busyWorkers ?? 0 }} / {{ $freeWorkers ?? 0 }}</div>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 mt-4">
                <h2 class="text-xl font-semibold mb-4">Overview & Analytics</h2>
                <!-- Placeholder for tables/graphs -->
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <span>Tables and graphs will appear here.</span>
                </div>
            </div>
        </div>
        <div id="section-users" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Users</h2>
            <div class="mb-4 flex justify-end">
                <button id="openAddUserModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add User</button>
            </div>
            <!-- Add User Modal -->
            <div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
                    <button id="closeAddUserModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    <h2 class="text-xl font-bold mb-4 text-center">Add New User</h2>
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-6">
                            <label for="role_id" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                            <select name="role_id" id="role_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create User</button>
                            <button type="button" id="cancelAddUserModal" class="text-sm text-blue-500 hover:text-blue-800">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Role</th>
                            <th class="py-3 px-6 text-left">Created At</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $user->name }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $user->email }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ ucfirst($user->role->name ?? 'No Role') }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if($user->role && $user->role->name === 'admin')
                                <span class="text-gray-400">Admin</span>
                                @else
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700 mx-2">Edit</a>
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 mx-2">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="section-services" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Services</h2>
            <!-- Compressed Service Creation Form -->
            <div class="bg-white shadow rounded-lg p-4 mb-6 max-w-md mx-auto">
                <form action="{{ route('services.store') }}" method="POST" class="space-y-2">
                    @csrf
                    <div class="text-center text-base font-semibold mb-2">Add New Service</div>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="name" placeholder="Name" class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring w-full" required>
                        <input type="text" name="description" placeholder="Description" class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring w-full" required>
                        <input type="number" name="price" placeholder="Price (Ksh)" class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring w-full" required>
                        <input type="number" name="duration" placeholder="Duration (min)" class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring w-full" required min="1">
                    </div>
                    <div class="pt-2 text-center">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-4 rounded">Create Service</button>
                    </div>
                </form>
            </div>
            <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Duration (min)</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($services as $service)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $service->name }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $service->description }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                Ksh {{ number_format($service->price, 2) }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $service->duration }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('services.edit', $service) }}" class="text-blue-500 hover:text-blue-700 mx-2">Edit</a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 mx-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="section-employees" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Employees</h2>
            <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Created At</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($users->where('role.name', 'employee') as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $user->name }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $user->email }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700 mx-2">Edit</a>
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 mx-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="section-appointments" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Appointments</h2>
            <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Date & Time</th>
                            <th class="py-3 px-6 text-left">Service</th>
                            <th class="py-3 px-6 text-left">Client</th>
                            <th class="py-3 px-6 text-left">Assigned Employee</th>
                            <th class="py-3 px-6 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($bookings as $booking)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">
                                {{ $booking->appointment_time }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $booking->service->name ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $booking->customer->name ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $booking->employee->user->name ?? 'To be assigned' }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                    {{ ucfirst($booking->status ?? 'pending') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="section-bookings" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Bookings</h2>
            <p>Here you can manage bookings.</p>
        </div>
        <div id="section-payments" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Payments</h2>
            <p>Here you can manage payments.</p>
        </div>
        <div id="section-reviews" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Manage Reviews</h2>
            <p>Here you can manage reviews.</p>
        </div>
        <div id="section-notifications" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Notifications</h2>
            <p>Here you can view notifications.</p>
        </div>
        <div id="section-settings" class="admin-section hidden">
            <h2 class="text-2xl font-bold mb-4">Settings</h2>
            <p>Here you can change system settings.</p>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.admin-section');
        const sidebarLinks = [{
                btn: 'sidebar-dashboard',
                section: 'section-dashboard'
            },
            {
                btn: 'sidebar-users',
                section: 'section-users'
            },
            {
                btn: 'sidebar-services',
                section: 'section-services'
            },
            {
                btn: 'sidebar-employees',
                section: 'section-employees'
            },
            {
                btn: 'sidebar-appointments',
                section: 'section-appointments'
            },
            {
                btn: 'sidebar-bookings',
                section: 'section-bookings'
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
            },
        ];
        sidebarLinks.forEach(link => {
            document.getElementById(link.btn).addEventListener('click', function(e) {
                e.preventDefault();
                sections.forEach(sec => sec.classList.add('hidden'));
                document.getElementById(link.section).classList.remove('hidden');
            });
        });

        // Add User Modal logic
        const openAddUserModalBtn = document.getElementById('openAddUserModal');
        const addUserModal = document.getElementById('addUserModal');
        const closeAddUserModalBtn = document.getElementById('closeAddUserModal');
        const cancelAddUserModalBtn = document.getElementById('cancelAddUserModal');
        if (openAddUserModalBtn && addUserModal) {
            openAddUserModalBtn.addEventListener('click', function() {
                addUserModal.classList.remove('hidden');
            });
            closeAddUserModalBtn.addEventListener('click', function() {
                addUserModal.classList.add('hidden');
            });
            cancelAddUserModalBtn.addEventListener('click', function() {
                addUserModal.classList.add('hidden');
            });
        }
    });
</script>
@endsection
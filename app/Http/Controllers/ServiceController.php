<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function create()
    {
        $users = []; // Prevent undefined variable error
        return view('admin.dashboard', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);
        Service::create($validated);
        return redirect()->back()->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.dashboard', compact('service')); // Adjust if you have a dedicated view
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);
        $service->update($validated);
        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }
}

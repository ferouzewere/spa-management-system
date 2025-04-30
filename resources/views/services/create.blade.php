@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Add New Service</h1>
    <form action="{{ route('services.store') }}" method="POST" class="max-w-lg bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}" required>
            @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="description">Description</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
            @error('description')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="price">Price (Ksh)</label>
            <input type="number" name="price" id="price" step="0.01" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('price') }}" required>
            @error('price')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Service</button>
            <a href="{{ route('services.index') }}" class="text-sm text-blue-500 hover:text-blue-800">Cancel</a>
        </div>
    </form>
</div>
@endsection
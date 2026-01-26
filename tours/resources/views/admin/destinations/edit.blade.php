@extends('admin.layouts.master')
@section('title', 'Edit Destination')
@section('page-title', 'Edit: ' . $destination->name)

@section('content')
<form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Destination Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $destination->name) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" id="description" rows="8" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 font-mono @error('description') border-red-500 @enderror">{{ old('description', $destination->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="best_season" class="block text-sm font-medium text-gray-700 mb-2">Best Season</label>
                        <input type="text" name="best_season" value="{{ old('best_season', $destination->best_season) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="weather_city" class="block text-sm font-medium text-gray-700 mb-2">Weather City (API)</label>
                        <input type="text" name="weather_city" value="{{ old('weather_city', $destination->weather_city) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">SEO Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $destination->meta_title) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('meta_description', $destination->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Publish</h3>
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status', $destination->status) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $destination->featured) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700">Featured Destination</span>
                    </label>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t">
                    <a href="{{ route('admin.destinations.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">Update</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Images</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Image</label>
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" class="w-full h-32 object-cover rounded-lg mb-2">
                    @endif
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                    @if($destination->banner_image)
                        <img src="{{ asset('storage/' . $destination->banner_image) }}" class="w-full h-32 object-cover rounded-lg mb-2">
                    @endif
                    <input type="file" name="banner_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Location</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" value="{{ old('latitude', $destination->latitude) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" value="{{ old('longitude', $destination->longitude) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
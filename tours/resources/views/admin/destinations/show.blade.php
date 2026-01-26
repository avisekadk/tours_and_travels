@extends('admin.layouts.master')
@section('title', 'View Destination')
@section('page-title', 'Destination Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-64 w-full bg-gray-200 relative">
                @if($destination->banner_image)
                    <img src="{{ asset('storage/' . $destination->banner_image) }}" alt="Banner" class="w-full h-full object-cover">
                @elseif($destination->image)
                    <img src="{{ asset('storage/' . $destination->image) }}" alt="Thumbnail" class="w-full h-full object-cover blur-sm">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">No Banner Image</div>
                @endif
                
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                    <h1 class="text-3xl font-bold text-white">{{ $destination->name }}</h1>
                    <p class="text-white/80 text-sm">/{{ $destination->slug }}</p>
                </div>
            </div>

            <div class="p-6">
                <div class="flex gap-2 mb-6">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $destination->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $destination->status ? 'Active' : 'Inactive' }}
                    </span>
                    @if($destination->featured)
                        <span class="px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">Featured</span>
                    @endif
                </div>

                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($destination->description)) !!}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Associated Tours ({{ $destination->tours->count() }})</h3>
            @if($destination->tours->count() > 0)
                <div class="grid gap-4">
                    @foreach($destination->tours as $tour)
                    <a href="{{ route('admin.tours.show', $tour->id) }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-blue-500 transition">
                        @if($tour->featured_image)
                            <img src="{{ asset('storage/' . $tour->featured_image) }}" class="w-12 h-12 rounded object-cover mr-3">
                        @else
                            <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900">{{ $tour->title }}</p>
                            <p class="text-xs text-gray-500">{{ $tour->duration }} Days • ${{ number_format($tour->price, 2) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No tours linked to this destination yet.</p>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Quick Details</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Best Season</dt>
                    <dd class="font-medium text-gray-900">{{ $destination->best_season ?? 'Not set' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Weather City</dt>
                    <dd class="font-medium text-gray-900">{{ $destination->weather_city ?? 'Not set' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Latitude</dt>
                    <dd class="font-mono text-xs text-gray-600">{{ $destination->latitude ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Longitude</dt>
                    <dd class="font-mono text-xs text-gray-600">{{ $destination->longitude ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">SEO Preview</h3>
            <div>
                <p class="text-xs text-gray-500 uppercase">Title</p>
                <p class="text-sm font-medium mb-2">{{ $destination->meta_title ?? $destination->name }}</p>
                
                <p class="text-xs text-gray-500 uppercase">Description</p>
                <p class="text-sm text-gray-600">{{ $destination->meta_description ?? Str::limit($destination->description, 100) }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="w-full py-2 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700">Edit Destination</a>
            <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST" onsubmit="return confirm('Delete this destination?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition">Delete Destination</button>
            </form>
        </div>
    </div>
</div>
@endsection
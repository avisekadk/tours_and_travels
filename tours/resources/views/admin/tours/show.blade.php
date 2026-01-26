@extends('admin.layouts.master')
@section('title', $tour->title)
@section('page-title', 'Tour Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="relative h-64">
                @if($tour->featured_image)
                    <img src="{{ asset('storage/' . $tour->featured_image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-white/90 backdrop-blur-sm shadow-sm">
                        {{ ucfirst($tour->status) }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $tour->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $tour->duration }} Days</span>
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> {{ $tour->destination->name ?? 'N/A' }}</span>
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> {{ $tour->category->name ?? 'N/A' }}</span>
                </div>
                
                <h3 class="text-lg font-bold mb-2">Description</h3>
                <div class="prose max-w-none text-gray-700 mb-6">
                    {!! nl2br(e($tour->description)) !!}
                </div>

                @if($tour->itinerary)
                <h3 class="text-lg font-bold mb-4">Itinerary</h3>
                <div class="border-l-2 border-blue-200 ml-3 space-y-6">
                    @foreach($tour->itinerary as $day)
                        <div class="relative pl-6">
                            <div class="absolute -left-2 top-0 w-4 h-4 rounded-full bg-blue-500"></div>
                            <h4 class="font-semibold text-gray-900">Day {{ $day['day'] }}: {{ $day['title'] }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $day['description'] }}</p>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pricing & Capacity</h3>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Regular Price</span>
                    <span class="font-bold">${{ number_format($tour->price, 2) }}</span>
                </div>
                @if($tour->sale_price)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Sale Price</span>
                    <span class="font-bold text-green-600">${{ number_format($tour->sale_price, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Difficulty</span>
                    <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100">{{ ucfirst($tour->difficulty) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Max People</span>
                    <span>{{ $tour->max_people ?? 'Unlimited' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Stats</h3>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="block text-2xl font-bold text-blue-600">{{ $tour->views }}</span>
                    <span class="text-xs text-blue-600">Views</span>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="block text-2xl font-bold text-green-600">{{ $tour->bookings->count() }}</span>
                    <span class="text-xs text-green-600">Bookings</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.tours.edit', $tour->id) }}" class="w-full py-2 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700">Edit Tour</a>
            <a href="{{ route('tours.show', $tour->slug) }}" target="_blank" class="w-full py-2 border border-gray-300 text-gray-700 rounded-lg text-center hover:bg-gray-50">View on Frontend</a>
        </div>
    </div>
</div>
@endsection
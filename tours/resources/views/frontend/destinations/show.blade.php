{{-- resources/views/frontend/destinations/show.blade.php --}}
@extends('frontend.layouts.master')

@section('title', $destination->meta_title ?? $destination->name . ' - HimalayaVoyage')
@section('meta_description', $destination->meta_description ?? Str::limit($destination->description, 155))

@section('content')

<!-- Destination Hero -->
<section class="relative h-96 md:h-[500px]">
    @if($destination->banner_image)
        <img src="{{ asset('storage/' . $destination->banner_image) }}" 
             alt="{{ $destination->name }}" 
             class="absolute inset-0 w-full h-full object-cover">
    @elseif($destination->image)
        <img src="{{ asset('storage/' . $destination->image) }}" 
             alt="{{ $destination->name }}" 
             class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-green-600 to-blue-600"></div>
    @endif
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    
    <div class="relative container mx-auto px-4 h-full flex items-end pb-12">
        <div class="text-white max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                @if($destination->featured)
                    <span class="px-3 py-1 bg-yellow-400 text-gray-900 rounded-full text-sm font-semibold">
                        Featured Destination
                    </span>
                @endif
                @if($destination->best_season)
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                        Best: {{ $destination->best_season }}
                    </span>
                @endif
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-4">{{ $destination->name }}</h1>
            
            <div class="flex flex-wrap items-center gap-6 text-white/90">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Nepal
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $destination->tours->count() }} Tours Available
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Main Content -->
            <div class="lg:w-2/3">
                
                <!-- About Destination -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6">About {{ $destination->name }}</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($destination->description)) !!}
                    </div>
                </div>
                
                <!-- Weather Info -->
                @if($destination->latitude && $destination->longitude)
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold mb-6">Weather Information</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3">Best Time to Visit</h3>
                                <p class="text-gray-700">{{ $destination->best_season ?? 'All year round' }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3">Climate</h3>
                                <p class="text-gray-700">
                                    The climate varies by altitude and season. Generally, autumn (September-November) and spring (March-May) offer the best weather for visiting.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Available Tours -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold mb-6">Tours in {{ $destination->name }}</h2>
                    
                    @if($destination->tours->count() > 0)
                        <div class="space-y-6">
                            @foreach($destination->tours as $tour)
                                <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                                    <div class="md:flex">
                                        <!-- Tour Image -->
                                        <div class="md:w-1/3">
                                            @if($tour->featured_image)
                                                <img src="{{ asset('storage/' . $tour->featured_image) }}" 
                                                     alt="{{ $tour->title }}" 
                                                     class="w-full h-48 md:h-full object-cover">
                                            @else
                                                <div class="w-full h-48 md:h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                                            @endif
                                        </div>
                                        
                                        <!-- Tour Details -->
                                        <div class="md:w-2/3 p-6">
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                        <a href="{{ route('tours.show', $tour->slug) }}" class="hover:text-blue-600 transition">
                                                            {{ $tour->title }}
                                                        </a>
                                                    </h3>
                                                    <p class="text-sm text-gray-500">{{ $tour->category->name ?? 'Tour' }}</p>
                                                </div>
                                                <div class="text-right">
                                                    @if($tour->sale_price)
                                                        <div class="text-2xl font-bold text-blue-600">${{ number_format($tour->sale_price, 0) }}</div>
                                                        <div class="text-sm text-gray-500 line-through">${{ number_format($tour->price, 0) }}</div>
                                                    @else
                                                        <div class="text-2xl font-bold text-blue-600">${{ number_format($tour->price, 0) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                {{ $tour->short_description }}
                                            </p>
                                            
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $tour->duration }} days
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ ucfirst($tour->difficulty) }}
                                                </span>
                                                @if($tour->reviewCount() > 0)
                                                    <span class="flex items-center">
                                                        ⭐ {{ number_format($tour->averageRating(), 1) }} ({{ $tour->reviewCount() }})
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <a href="{{ route('tours.show', $tour->slug) }}" 
                                               class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No tours available for this destination yet.</p>
                            <a href="{{ route('tours.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-semibold">
                                Browse all tours →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:w-1/3">
                
                <!-- Quick Info -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Quick Info</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1">Location</p>
                            <p class="font-semibold">Nepal</p>
                        </div>
                        
                        @if($destination->best_season)
                            <div>
                                <p class="text-gray-600 mb-1">Best Season</p>
                                <p class="font-semibold">{{ $destination->best_season }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-gray-600 mb-1">Available Tours</p>
                            <p class="font-semibold">{{ $destination->tours->count() }} tours</p>
                        </div>
                        
                        @if($destination->latitude && $destination->longitude)
                            <div>
                                <p class="text-gray-600 mb-1">Coordinates</p>
                                <p class="font-semibold text-xs">{{ $destination->latitude }}, {{ $destination->longitude }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <hr class="my-6">
                    
                    <div class="space-y-3">
                        <a href="{{ route('tours.index', ['destination' => $destination->slug]) }}" 
                           class="block w-full px-6 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition">
                            View All Tours
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="block w-full px-6 py-3 bg-gray-100 text-gray-700 text-center rounded-lg font-semibold hover:bg-gray-200 transition">
                            Plan Custom Trip
                        </a>
                    </div>
                </div>
                
                <!-- Map (Optional) -->
                @if($destination->latitude && $destination->longitude)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4">Location Map</h3>
                        <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500 text-sm">Map placeholder</p>
                            <!-- You can integrate Google Maps or similar here -->
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Related Destinations -->
@php
    $relatedDestinations = \App\Models\Destination::active()
        ->where('id', '!=', $destination->id)
        ->inRandomOrder()
        ->take(3)
        ->get();
@endphp

@if($relatedDestinations->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">More Destinations to Explore</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($relatedDestinations as $related)
                    <a href="{{ route('destinations.show', $related->slug) }}" 
                       class="group relative h-80 rounded-2xl overflow-hidden">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500"></div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">{{ $related->name }}</h3>
                            <p class="text-sm text-white/90">{{ $related->tours_count }} tours</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
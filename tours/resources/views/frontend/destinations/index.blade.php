{{-- resources/views/frontend/destinations/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Destinations - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Explore Nepal Destinations</h1>
        <p class="text-xl">Discover the beauty of the Himalayas</p>
    </div>
</section>

<!-- Destinations Grid -->
<section class="py-16">
    <div class="container mx-auto px-4">
        
        @if($destinations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($destinations as $destination)
                    <article class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                        
                        <!-- Destination Image -->
                        <a href="{{ route('destinations.show', $destination->slug) }}" class="block relative h-80 overflow-hidden">
                            @if($destination->image)
                                <img src="{{ asset('storage/' . $destination->image) }}" 
                                     alt="{{ $destination->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500"></div>
                            @endif
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            
                            <!-- Featured Badge -->
                            @if($destination->featured)
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-yellow-400 text-gray-900 rounded-full text-sm font-semibold">
                                        Featured
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Content Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h2 class="text-3xl font-bold text-white mb-2">{{ $destination->name }}</h2>
                                <div class="flex items-center text-white/90 text-sm mb-3">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Nepal
                                </div>
                                <p class="text-white/90 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit($destination->description, 120) }}
                                </p>
                                
                                <!-- Tour Count -->
                                <div class="flex items-center justify-between">
                                    <span class="text-white/90 text-sm">
                                        {{ $destination->tours_count }} {{ Str::plural('tour', $destination->tours_count) }} available
                                    </span>
                                    <span class="text-white group-hover:translate-x-2 transition">
                                        →
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $destinations->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🏔️</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No destinations found</h3>
                <p class="text-gray-600">Check back soon for new destinations!</p>
            </div>
        @endif
    </div>
</section>

<!-- Popular Destinations Info -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Why Visit Nepal?</h2>
            <p class="text-lg text-gray-700 mb-8">
                Nepal is home to eight of the world's ten highest mountains, including Mount Everest. 
                From the bustling streets of Kathmandu to the serene lakes of Pokhara, and from 
                ancient temples to pristine wilderness, Nepal offers diverse experiences for every traveler.
            </p>
            
            <div class="grid md:grid-cols-3 gap-8 mt-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🏔️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Mountain Peaks</h3>
                    <p class="text-gray-600 text-sm">Eight of the world's highest mountains</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🕉️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Rich Culture</h3>
                    <p class="text-gray-600 text-sm">Ancient temples and spiritual heritage</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🐘</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Wildlife</h3>
                    <p class="text-gray-600 text-sm">Diverse flora and fauna in national parks</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
{{-- resources/views/frontend/profile/favorites.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'My Favorites - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-2">My Favorites</h1>
        <p class="text-white/90">Tours you've saved for later</p>
    </div>
</section>

<!-- Favorites Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        
        @if($favorites->count() > 0)
            <!-- Favorites Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($favorites as $favorite)
                    @php $tour = $favorite->tour; @endphp
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                        <!-- Tour Image -->
                        <div class="relative h-64">
                            @if($tour->featured_image)
                                <img src="{{ asset('storage/' . $tour->featured_image) }}" 
                                     alt="{{ $tour->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            @endif
                            
                            <!-- Remove from Favorites -->
                            <form action="{{ route('favorites.destroy', $favorite) }}" method="POST" class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-10 h-10 bg-red-500 text-white rounded-full hover:bg-red-600 transition flex items-center justify-center">
                                    ❤️
                                </button>
                            </form>
                            
                            <!-- Difficulty Badge -->
                            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-sm font-semibold">
                                {{ ucfirst($tour->difficulty) }}
                            </div>
                            
                            <!-- Price Tag -->
                            @if($tour->sale_price)
                                <div class="absolute bottom-4 left-4 bg-yellow-400 px-4 py-2 rounded-lg">
                                    <span class="text-lg font-bold">${{ number_format($tour->sale_price, 0) }}</span>
                                    <span class="text-sm line-through ml-2">${{ number_format($tour->price, 0) }}</span>
                                </div>
                            @else
                                <div class="absolute bottom-4 left-4 bg-yellow-400 px-4 py-2 rounded-lg">
                                    <span class="text-lg font-bold">${{ number_format($tour->price, 0) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tour Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $tour->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $tour->short_description }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>📅 {{ $tour->duration }} Days</span>
                                <span>📍 {{ $tour->destination->name ?? 'Nepal' }}</span>
                            </div>
                            
                            <!-- Notes -->
                            @if($favorite->notes)
                                <div class="mb-4 p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-sm text-gray-700">{{ $favorite->notes }}</p>
                                </div>
                            @endif
                            
                            <a href="{{ route('tours.show', $tour->slug) }}" 
                               class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">❤️</div>
                <h3 class="text-2xl font-bold mb-2">No favorites yet</h3>
                <p class="text-gray-600 mb-6">Start adding tours to your favorites to plan your perfect trip!</p>
                <a href="{{ route('tours.index') }}" 
                   class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Browse Tours
                </a>
            </div>
        @endif
    </div>
</section>

@endsection
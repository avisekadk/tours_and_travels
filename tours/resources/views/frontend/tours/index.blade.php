{{-- resources/views/frontend/tours/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'All Tours - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Explore Our Tours</h1>
        <p class="text-xl">Find your perfect Nepal adventure</p>
    </div>
</section>

<!-- Filters & Tours -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-6">Filter Tours</h3>
                    
                    <form action="{{ route('tours.index') }}" method="GET">
                        
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Destination Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Destination</label>
                            <select name="destination" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Destinations</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->slug }}" {{ request('destination') == $destination->slug ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Difficulty Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Difficulty</label>
                            <select name="difficulty" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">All Levels</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="moderate" {{ request('difficulty') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                <option value="challenging" {{ request('difficulty') == 'challenging' ? 'selected' : '' }}>Challenging</option>
                                <option value="difficult" {{ request('difficulty') == 'difficult' ? 'selected' : '' }}>Difficult</option>
                            </select>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Price Range</label>
                            <div class="flex gap-2">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                       class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                       class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <!-- Duration -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (Days)</label>
                            <div class="flex gap-2">
                                <input type="number" name="min_duration" placeholder="Min" value="{{ request('min_duration') }}"
                                       class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <input type="number" name="max_duration" placeholder="Max" value="{{ request('max_duration') }}"
                                       class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition mb-2">
                            Apply Filters
                        </button>
                        <a href="{{ route('tours.index') }}" class="block w-full px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                            Clear Filters
                        </a>
                    </form>
                </div>
            </aside>
            
            <!-- Tours Grid -->
            <div class="lg:w-3/4">
                
                <!-- Sort & Results Count -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <p class="text-gray-600 mb-4 sm:mb-0">
                        Showing {{ $tours->firstItem() ?? 0 }} - {{ $tours->lastItem() ?? 0 }} of {{ $tours->total() }} tours
                    </p>
                    
                    <form action="{{ route('tours.index') }}" method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </form>
                </div>
                
                @if($tours->count() > 0)
                    <!-- Tours Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($tours as $tour)
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
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-sm font-semibold">
                                            {{ ucfirst($tour->difficulty) }}
                                        </span>
                                        @if($tour->featured)
                                            <span class="px-3 py-1 bg-yellow-400 rounded-full text-sm font-semibold">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Price -->
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
                                    
                                    <!-- Rating -->
                                    @if($tour->reviewCount() > 0)
                                        <div class="flex items-center mb-4">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= round($tour->averageRating()) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600">({{ $tour->reviewCount() }} reviews)</span>
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
                        {{ $tours->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <p class="text-gray-500 text-xl">No tours found matching your criteria.</p>
                        <a href="{{ route('tours.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            View All Tours
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
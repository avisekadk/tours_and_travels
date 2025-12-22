{{-- resources/views/frontend/home/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'HimalayaVoyage - Discover Nepal')

@section('content')

<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center bg-gradient-to-r from-blue-900 to-purple-900">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    
    <div class="relative z-10 text-center text-white px-4">
        <h1 class="text-5xl md:text-7xl font-bold mb-6">
            Discover the <span class="text-yellow-400">Himalayas</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8">Your Nepal Adventure Begins Here</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('tours.index') }}" class="px-8 py-4 bg-blue-600 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                Explore Tours
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                Plan Your Trip
            </a>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Statistics -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-blue-600">{{ $stats['total_tours'] }}+</div>
                <div class="text-gray-600 mt-2">Tours</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600">{{ $stats['happy_travelers'] }}+</div>
                <div class="text-gray-600 mt-2">Happy Travelers</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600">{{ $stats['destinations'] }}+</div>
                <div class="text-gray-600 mt-2">Destinations</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600">{{ $stats['years_experience'] }}+</div>
                <div class="text-gray-600 mt-2">Years Experience</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Tours -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Featured Tours</h2>
            <p class="text-gray-600">Discover our most popular adventures</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredTours as $tour)
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
                        
                        <!-- Difficulty Badge -->
                        <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-sm font-semibold">
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
                        
                        <a href="{{ route('tours.show', $tour->slug) }}" 
                           class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('tours.index') }}" class="inline-block px-8 py-3 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition">
                View All Tours
            </a>
        </div>
    </div>
</section>

<!-- Destinations -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Popular Destinations</h2>
            <p class="text-gray-600">Explore the beauty of Nepal</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredDestinations as $destination)
                <a href="{{ route('destinations.show', $destination->slug) }}" 
                   class="relative h-80 rounded-2xl overflow-hidden group">
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" 
                             alt="{{ $destination->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500"></div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $destination->name }}</h3>
                        <p class="text-sm text-gray-200">{{ $destination->tours->count() }} Tours Available</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Travelers Say</h2>
            <p class="text-gray-600">Real experiences from real adventurers</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials->take(3) as $review)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <!-- Rating -->
                    <div class="flex items-center mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    
                    <!-- Review -->
                    <p class="text-gray-700 mb-4">{{ Str::limit($review->comment, 120) }}</p>
                    
                    <!-- User Info -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-800">{{ $review->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $review->tour->title }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Latest Travel Stories</h2>
            <p class="text-gray-600">Tips, guides, and inspiration for your Nepal journey</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestBlogs as $blog)
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    <div class="relative h-48">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-pink-500"></div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">
                            {{ $blog->published_at->format('M d, Y') }} • {{ $blog->reading_time }} min read
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $blog->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $blog->excerpt }}</p>
                        
                        <a href="{{ route('blog.show', $blog->slug) }}" 
                           class="text-blue-600 font-semibold hover:text-blue-700">
                            Read More →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-block px-8 py-3 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition">
                View All Posts
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="text-4xl font-bold mb-4">Ready for Your Adventure?</h2>
        <p class="text-xl mb-8">Let us help you plan the perfect Nepal experience</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('tours.index') }}" class="px-8 py-4 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                Browse Tours
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg text-lg font-semibold hover:bg-white/10 transition">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
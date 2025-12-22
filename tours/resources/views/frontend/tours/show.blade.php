{{-- resources/views/frontend/tours/show.blade.php --}}
@extends('frontend.layouts.master')

@section('title', $tour->meta_title ?? $tour->title . ' - HimalayaVoyage')
@section('meta_description', $tour->meta_description ?? $tour->short_description)

@section('content')

<!-- Tour Header -->
<section class="relative h-96 bg-gradient-to-r from-blue-600 to-purple-600">
    @if($tour->featured_image)
        <img src="{{ asset('storage/' . $tour->featured_image) }}" 
             alt="{{ $tour->title }}" 
             class="absolute inset-0 w-full h-full object-cover mix-blend-overlay">
    @endif
    
    <div class="absolute inset-0 bg-black/40"></div>
    
    <div class="relative container mx-auto px-4 h-full flex items-center">
        <div class="text-white max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    {{ $tour->category->name ?? 'Tour' }}
                </span>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    {{ ucfirst($tour->difficulty) }}
                </span>
                @if($tour->featured)
                    <span class="px-3 py-1 bg-yellow-400 text-gray-900 rounded-full text-sm font-semibold">
                        Featured
                    </span>
                @endif
            </div>
            
            <h1 class="text-5xl font-bold mb-4">{{ $tour->title }}</h1>
            <p class="text-xl mb-6">{{ $tour->short_description }}</p>
            
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center">
                    <span class="mr-2">📅</span>
                    {{ $tour->duration }} {{ $tour->duration_type }}
                </div>
                
                <div class="flex items-center">
                    <span class="mr-2">📍</span>
                    {{ $tour->destination->name ?? $tour->location }}
                </div>
                
                @if($tour->reviewCount() > 0)
                    <div class="flex items-center">
                        <span class="mr-2">⭐</span>
                        {{ number_format($tour->averageRating(), 1) }} ({{ $tour->reviewCount() }} reviews)
                    </div>
                @endif
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
                
                <!-- Overview -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6">Overview</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($tour->description)) !!}
                    </div>
                </div>
                
                <!-- Highlights -->
                @if($tour->highlights)
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold mb-6">Tour Highlights</h2>
                        <ul class="space-y-3">
                            @foreach($tour->highlights as $highlight)
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-3 text-xl">✓</span>
                                    <span>{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Itinerary -->
                @if($tour->itinerary)
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold mb-6">Itinerary</h2>
                        <div class="space-y-4">
                            @foreach($tour->itinerary as $day)
                                <div class="border-l-4 border-blue-500 pl-6 py-4">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                            {{ $day['day'] }}
                                        </div>
                                        <h3 class="text-xl font-semibold">{{ $day['title'] }}</h3>
                                    </div>
                                    <p class="text-gray-600 ml-14">{{ $day['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Inclusions & Exclusions -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    @if($tour->inclusions)
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-4 text-green-600">What's Included</h3>
                            <ul class="space-y-2">
                                @foreach($tour->inclusions as $inclusion)
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2">✓</span>
                                        <span class="text-gray-700">{{ $inclusion }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if($tour->exclusions)
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-4 text-red-600">What's Not Included</h3>
                            <ul class="space-y-2">
                                @foreach($tour->exclusions as $exclusion)
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">✗</span>
                                        <span class="text-gray-700">{{ $exclusion }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                
                <!-- Important Notes -->
                @if($tour->important_notes)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-2xl p-8 mb-8">
                        <h3 class="text-2xl font-bold mb-4 text-yellow-800">Important Information</h3>
                        <ul class="space-y-2">
                            @foreach($tour->important_notes as $note)
                                <li class="flex items-start">
                                    <span class="text-yellow-600 mr-2">⚠</span>
                                    <span class="text-gray-700">{{ $note }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Reviews Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold mb-6">Reviews</h2>
                    
                    @if($tour->reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($tour->reviews as $review)
                                <div class="border-b pb-6 last:border-b-0">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $review->user->name }}</div>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                @endfor
                                                <span class="text-gray-500 text-sm ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($review->title)
                                        <h4 class="font-semibold mb-2">{{ $review->title }}</h4>
                                    @endif
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                    
                                    @if($review->admin_reply)
                                        <div class="mt-4 ml-12 bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-semibold text-blue-600 mb-2">Response from HimalayaVoyage:</p>
                                            <p class="text-gray-700">{{ $review->admin_reply }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No reviews yet. Be the first to review this tour!</p>
                    @endif
                    
                    @auth
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                            <form action="{{ route('reviews.store', $tour) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                                    <div class="flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                                <span class="text-3xl text-gray-300 peer-checked:text-yellow-400">★</span>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Review Title (Optional)</label>
                                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Review</label>
                                    <textarea name="comment" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required></textarea>
                                </div>
                                
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-8 pt-8 border-t text-center">
                            <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-blue-600 font-semibold">login</a> to write a review</p>
                        </div>
                    @endauth
                </div>
            </div>
            
            <!-- Sidebar - Booking Widget -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <!-- Price -->
                    <div class="mb-6">
                        @if($tour->sale_price)
                            <div class="flex items-baseline">
                                <span class="text-4xl font-bold text-blue-600">${{ number_format($tour->sale_price, 0) }}</span>
                                <span class="text-xl text-gray-400 line-through ml-2">${{ number_format($tour->price, 0) }}</span>
                            </div>
                            <div class="text-sm text-green-600 font-semibold mt-1">
                                Save ${{ number_format($tour->price - $tour->sale_price, 0) }} ({{ $tour->discount_percentage }}% off)
                            </div>
                        @else
                            <span class="text-4xl font-bold text-blue-600">${{ number_format($tour->price, 0) }}</span>
                        @endif
                        <div class="text-gray-600 mt-1">per person</div>
                    </div>
                    
                    <!-- Quick Info -->
                    <div class="space-y-3 mb-6 pb-6 border-b">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-semibold">{{ $tour->duration }} Days</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Difficulty:</span>
                            <span class="font-semibold">{{ ucfirst($tour->difficulty) }}</span>
                        </div>
                        @if($tour->max_people)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Group Size:</span>
                                <span class="font-semibold">Max {{ $tour->max_people }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- CTA Buttons -->
                    @auth
                        <a href="{{ route('bookings.create', $tour) }}" class="block w-full px-6 py-4 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition mb-3">
                            Book Now
                        </a>
                        
                        <form action="{{ route('favorites.toggle', $tour) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                                {{ $isFavorited ? '❤️ Added to Favorites' : '🤍 Add to Favorites' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full px-6 py-4 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition mb-3">
                            Login to Book
                        </a>
                    @endauth
                    
                    <!-- Contact Info -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="text-center mb-4">
                            <p class="text-gray-600 text-sm mb-2">Need help?</p>
                            <a href="tel:+97714444444" class="text-blue-600 font-semibold hover:text-blue-700">
                                📞 +977-1-4444444
                            </a>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full px-6 py-3 bg-gray-100 text-gray-700 text-center rounded-lg font-semibold hover:bg-gray-200 transition">
                            Send Inquiry
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Tours -->
@if($relatedTours->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">Similar Tours</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($relatedTours as $relatedTour)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                        <div class="relative h-48">
                            @if($relatedTour->featured_image)
                                <img src="{{ asset('storage/' . $relatedTour->featured_image) }}" 
                                     alt="{{ $relatedTour->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            @endif
                            
                            <div class="absolute bottom-4 left-4 bg-yellow-400 px-3 py-1 rounded-lg">
                                <span class="font-bold">${{ number_format($relatedTour->display_price, 0) }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-2">{{ Str::limit($relatedTour->title, 50) }}</h3>
                            <div class="flex justify-between text-sm text-gray-500 mb-3">
                                <span>📅 {{ $relatedTour->duration }} Days</span>
                                <span>{{ ucfirst($relatedTour->difficulty) }}</span>
                            </div>
                            
                            <a href="{{ route('tours.show', $relatedTour->slug) }}" 
                               class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
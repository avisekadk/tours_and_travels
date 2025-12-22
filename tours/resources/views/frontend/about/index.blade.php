{{-- resources/views/frontend/about/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'About Us - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">About HimalayaVoyage</h1>
        <p class="text-xl">Your trusted partner for Nepal adventures since 2009</p>
    </div>
</section>

<!-- Our Story -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-8">Our Story</h2>
            <div class="text-gray-700 space-y-4">
                <p>
                    Founded in 2009, HimalayaVoyage was born from a passion for sharing the incredible beauty and rich culture of Nepal with travelers from around the world. What started as a small team of enthusiastic guides has grown into one of Nepal's most trusted tour operators.
                </p>
                <p>
                    We specialize in creating unforgettable experiences that go beyond typical tourism. Our expert guides, many of whom are born and raised in the regions we explore, bring authentic insights and personal connections that make each journey truly special.
                </p>
                <p>
                    Whether you're trekking to Everest Base Camp, exploring ancient temples in Kathmandu, or spotting wildlife in Chitwan, we're committed to providing safe, sustainable, and memorable adventures that respect local communities and the environment.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Why Choose Us</h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🏔️</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Expert Guides</h3>
                <p class="text-gray-600">Our experienced, licensed guides ensure your safety while sharing deep knowledge of Nepal's culture.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🌿</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Sustainable Tourism</h3>
                <p class="text-gray-600">We practice responsible tourism that benefits local communities and protects the environment.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">⭐</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Best Value</h3>
                <p class="text-gray-600">Quality service at competitive prices with transparent, honest pricing and no hidden costs.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🛡️</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Safety First</h3>
                <p class="text-gray-600">Your safety is our priority. We maintain highest safety standards and comprehensive insurance.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">💼</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Custom Itineraries</h3>
                <p class="text-gray-600">We tailor each tour to your interests, fitness level, and schedule for personalized experience.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🤝</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">24/7 Support</h3>
                <p class="text-gray-600">From booking to return home, our team is available around the clock to assist you.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Meet Our Team</h2>
        
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-40 h-40 bg-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-5xl font-bold">
                    RT
                </div>
                <h3 class="text-xl font-bold mb-2">Ram Bahadur Tamang</h3>
                <p class="text-blue-600 mb-2">Founder & CEO</p>
                <p class="text-gray-600 text-sm">20+ years trekking experience</p>
            </div>
            
            <div class="text-center">
                <div class="w-40 h-40 bg-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-5xl font-bold">
                    SP
                </div>
                <h3 class="text-xl font-bold mb-2">Sita Paudel</h3>
                <p class="text-blue-600 mb-2">Operations Manager</p>
                <p class="text-gray-600 text-sm">Expert in tour logistics</p>
            </div>
            
            <div class="text-center">
                <div class="w-40 h-40 bg-green-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-5xl font-bold">
                    LG
                </div>
                <h3 class="text-xl font-bold mb-2">Lakpa Gyalzen Sherpa</h3>
                <p class="text-blue-600 mb-2">Lead Trekking Guide</p>
                <p class="text-gray-600 text-sm">Everest region specialist</p>
            </div>
            
            <div class="text-center">
                <div class="w-40 h-40 bg-pink-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-5xl font-bold">
                    MP
                </div>
                <h3 class="text-xl font-bold mb-2">Maya Prasad</h3>
                <p class="text-blue-600 mb-2">Customer Relations</p>
                <p class="text-gray-600 text-sm">Dedicated to your experience</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-8">Our Mission</h2>
            <p class="text-xl mb-12">
                To provide authentic, sustainable, and unforgettable travel experiences that connect people with the natural beauty and rich culture of Nepal, while supporting local communities and preserving the environment.
            </p>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold mb-2">Quality</h3>
                    <p>Excellence in every aspect of our service</p>
                </div>
                <div>
                    <div class="text-5xl mb-4">🤲</div>
                    <h3 class="text-2xl font-bold mb-2">Community</h3>
                    <p>Supporting local people and culture</p>
                </div>
                <div>
                    <div class="text-5xl mb-4">🌍</div>
                    <h3 class="text-2xl font-bold mb-2">Sustainability</h3>
                    <p>Protecting nature for generations</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Ready to Start Your Adventure?</h2>
        <p class="text-xl text-gray-600 mb-8">Let us help you create memories that last a lifetime</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('tours.index') }}" class="px-8 py-4 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                Explore Tours
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-gray-800 text-white rounded-lg text-lg font-semibold hover:bg-gray-900 transition">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
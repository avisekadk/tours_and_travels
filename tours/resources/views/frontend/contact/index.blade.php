{{-- resources/views/frontend/contact/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Contact Us - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Get In Touch</h1>
        <p class="text-xl">We're here to help plan your perfect Nepal adventure</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12">
            
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-3xl font-bold mb-6">Send us a Message</h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('subject') border-red-500 @enderror" 
                               required>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="5" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror" 
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full px-6 py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-2xl">📍</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Address</div>
                                <div class="text-gray-600">Thamel, Kathmandu, Nepal</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-2xl">📞</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Phone</div>
                                <div class="text-gray-600">+977-1-4444444</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-2xl">📧</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Email</div>
                                <div class="text-gray-600">info@himalayavoyage.com</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-2xl">💬</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">WhatsApp</div>
                                <div class="text-gray-600">+977-9841234567</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Business Hours -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold mb-6">Business Hours</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Friday:</span>
                            <span class="font-semibold">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday:</span>
                            <span class="font-semibold">9:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday:</span>
                            <span class="font-semibold text-red-600">Closed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
{{-- resources/views/auth/register.blade.php --}}
@extends('auth.layouts.auth')

@section('title', 'Register')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
    <p class="text-gray-600 text-sm mt-1">Join us for amazing adventures</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
        <input type="text" 
               id="name" 
               name="name" 
               value="{{ old('name') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
               placeholder="John Doe"
               required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
        <input type="email" 
               id="email" 
               name="email" 
               value="{{ old('email') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
               placeholder="your@email.com"
               required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone -->
    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
        <input type="text" 
               id="phone" 
               name="phone" 
               value="{{ old('phone') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
               placeholder="+977-9841234567"
               required>
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" 
               id="password" 
               name="password"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
               placeholder="Min. 8 characters"
               required>
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
        <input type="password" 
               id="password_confirmation" 
               name="password_confirmation"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Re-enter password"
               required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
        Create Account
    </button>
</form>

<!-- Login Link -->
<div class="mt-6 text-center">
    <p class="text-sm text-gray-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700">
            Login here
        </a>
    </p>
</div>
@endsection
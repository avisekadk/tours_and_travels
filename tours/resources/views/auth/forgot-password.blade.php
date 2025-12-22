{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('auth.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Forgot Password?</h2>
    <p class="text-gray-600 text-sm mt-1">Enter your email to reset password</p>
</div>

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email -->
    <div class="mb-6">
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

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
        Send Reset Link
    </button>
</form>

<!-- Back to Login -->
<div class="mt-6 text-center">
    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700">
        ← Back to Login
    </a>
</div>
@endsection
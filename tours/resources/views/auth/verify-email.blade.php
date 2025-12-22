{{-- resources/views/auth/verify-email.blade.php --}}
@extends('auth.layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="text-center mb-6">
    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Verify Your Email</h2>
    <p class="text-gray-600 text-sm mt-2">We've sent a verification link to your email address</p>
</div>

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
        Resend Verification Email
    </button>
</form>

<div class="mt-6 text-center">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">
            Logout
        </button>
    </form>
</div>
@endsection
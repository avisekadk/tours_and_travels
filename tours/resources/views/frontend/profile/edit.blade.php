{{-- resources/views/frontend/profile/edit.blade.php }}
@extends('frontend.layouts.master')

@section('title', 'Edit Profile - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-2">Account Settings</h1>
        <p class="text-white/90">Manage your profile and account preferences</p>
    </div>
</section>

<!-- Settings Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Sidebar -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <div class="text-center mb-6">
                            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-4xl font-bold mx-auto mb-4">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <h3 class="font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div class="space-y-2">
                            <button onclick="showTab('profile')" id="tab-profile" 
                                    class="w-full text-left px-4 py-3 rounded-lg font-semibold transition bg-blue-600 text-white">
                                Profile Information
                            </button>
                            <button onclick="showTab('password')" id="tab-password" 
                                    class="w-full text-left px-4 py-3 rounded-lg font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                                Change Password
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="md:col-span-2">
                    
                    <!-- Profile Information Form -->
                    <div id="content-profile" class="bg-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-6">Profile Information</h2>
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Upload -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Picture</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100">
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (MAX. 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Name -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                Save Changes
                            </button>
                        </form>
                    </div>
                    
                    <!-- Change Password Form -->
                    <div id="content-password" class="bg-white rounded-2xl shadow-lg p-8 hidden">
                        <h2 class="text-2xl font-bold mb-6">Change Password</h2>
                        
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Current Password -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                <input type="password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                                       required>
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- New Password -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <input type="password" 
                                       name="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                       required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                       required>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function showTab(tab) {
    // Hide all content
    document.getElementById('content-profile').classList.add('hidden');
    document.getElementById('content-password').classList.add('hidden');
    
    // Reset all buttons
    document.getElementById('tab-profile').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('tab-profile').classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    document.getElementById('tab-password').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('tab-password').classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    
    // Show selected content and highlight button
    if (tab === 'profile') {
        document.getElementById('content-profile').classList.remove('hidden');
        document.getElementById('tab-profile').classList.add('bg-blue-600', 'text-white');
        document.getElementById('tab-profile').classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    } else if (tab === 'password') {
        document.getElementById('content-password').classList.remove('hidden');
        document.getElementById('tab-password').classList.add('bg-blue-600', 'text-white');
        document.getElementById('tab-password').classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    }
}
</script>
@endpush
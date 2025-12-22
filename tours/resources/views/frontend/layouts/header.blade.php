{{-- resources/views/frontend/layouts/header.blade.php --}}
<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    HimalayaVoyage
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('tours.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Tours</a>
                <a href="{{ route('destinations.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Destinations</a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Blog</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium">About</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
            </div>
            
            <!-- Auth Links -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        Dashboard
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                            Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Register
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('tours.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Tours</a>
                <a href="{{ route('destinations.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Destinations</a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Blog</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium">About</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                
                @auth
                    <a href="{{ route('profile.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-blue-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Register</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

@push('scripts')
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@endpush
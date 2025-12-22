{{-- resources/views/frontend/layouts/footer.blade.php --}}
<footer class="bg-gray-900 text-white mt-20">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- About -->
            <div>
                <h3 class="text-xl font-bold mb-4">HimalayaVoyage</h3>
                <p class="text-gray-400 text-sm">
                    Your gateway to Himalayan adventures. Experience Nepal with expert guides and unforgettable journeys.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('tours.index') }}" class="text-gray-400 hover:text-white">Tours</a></li>
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-white">Destinations</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white">Blog</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>📍 Thamel, Kathmandu, Nepal</li>
                    <li>📞 +977-1-4444444</li>
                    <li>📧 info@himalayavoyage.com</li>
                    <li>💬 WhatsApp: +977-9841234567</li>
                </ul>
            </div>
            
            <!-- Social Media -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700">
                        F
                    </a>
                    <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700">
                        I
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500">
                        T
                    </a>
                    <a href="#" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700">
                        Y
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} HimalayaVoyage. All rights reserved.</p>
        </div>
    </div>
</footer>
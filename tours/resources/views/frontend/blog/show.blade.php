{{-- resources/views/frontend/blog/show.blade.php --}}
@extends('frontend.layouts.master')

@section('title', $blog->meta_title ?? $blog->title . ' - HimalayaVoyage Blog')
@section('meta_description', $blog->meta_description ?? $blog->excerpt)

@section('content')

<!-- Blog Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-white">
            
            <!-- Category Badge -->
            @if($blog->category)
                <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}" 
                   class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4 hover:bg-white/30 transition">
                    {{ $blog->category->name }}
                </a>
            @endif
            
            <!-- Title -->
            <h1 class="text-5xl font-bold mb-6">{{ $blog->title }}</h1>
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-6 text-white/90">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-3">
                        <span class="text-lg font-bold">{{ substr($blog->author->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="font-semibold">{{ $blog->author->name }}</div>
                        <div class="text-sm">Author</div>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <span class="mr-2">📅</span>
                    {{ $blog->published_at->format('F d, Y') }}
                </div>
                
                <div class="flex items-center">
                    <span class="mr-2">⏱️</span>
                    {{ $blog->reading_time }} min read
                </div>
                
                <div class="flex items-center">
                    <span class="mr-2">👁️</span>
                    {{ number_format($blog->views) }} views
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Main Content -->
            <article class="lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                    
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="mb-8 rounded-xl overflow-hidden">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full h-auto">
                        </div>
                    @endif
                    
                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br($blog->content) !!}
                    </div>
                    
                    <!-- Tags -->
                    @if($blog->tags)
                        <div class="mt-8 pt-8 border-t">
                            <h4 class="text-lg font-semibold mb-4">Tags:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Share Buttons -->
                    <div class="mt-8 pt-8 border-t">
                        <h4 class="text-lg font-semibold mb-4">Share this post:</h4>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                                Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition">
                                LinkedIn
                            </a>
                            <button onclick="copyToClipboard()" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                Copy Link
                            </button>
                        </div>
                    </div>
                    
                    <!-- Author Box -->
                    <div class="mt-8 pt-8 border-t">
                        <div class="flex items-start gap-4 bg-gray-50 rounded-xl p-6">
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                                {{ substr($blog->author->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ $blog->author->name }}</h4>
                                <p class="text-gray-600">
                                    Travel writer and Nepal enthusiast. Sharing stories and tips to help you plan your perfect adventure.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Related Posts -->
                @if($relatedBlogs->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-3xl font-bold mb-6">Related Posts</h3>
                        
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach($relatedBlogs as $relatedBlog)
                                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                                    <div class="relative h-48">
                                        @if($relatedBlog->featured_image)
                                            <img src="{{ asset('storage/' . $relatedBlog->featured_image) }}" 
                                                 alt="{{ $relatedBlog->title }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-pink-500"></div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-4">
                                        <div class="text-sm text-gray-500 mb-2">
                                            {{ $relatedBlog->published_at->format('M d, Y') }}
                                        </div>
                                        <h4 class="font-bold text-gray-800 mb-2 line-clamp-2">
                                            {{ $relatedBlog->title }}
                                        </h4>
                                        <a href="{{ route('blog.show', $relatedBlog->slug) }}" 
                                           class="text-blue-600 font-semibold hover:text-blue-700 text-sm">
                                            Read More →
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
            
            <!-- Sidebar -->
            <aside class="lg:w-1/4">
                
                <!-- Latest Posts -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Latest Posts</h3>
                    <div class="space-y-4">
                        @php
                            $latestBlogs = \App\Models\Blog::published()->latest('published_at')->take(5)->get();
                        @endphp
                        
                        @foreach($latestBlogs as $latestBlog)
                            <a href="{{ route('blog.show', $latestBlog->slug) }}" 
                               class="flex gap-3 group">
                                @if($latestBlog->featured_image)
                                    <img src="{{ asset('storage/' . $latestBlog->featured_image) }}" 
                                         alt="{{ $latestBlog->title }}" 
                                         class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex-shrink-0"></div>
                                @endif
                                
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition line-clamp-2 mb-1">
                                        {{ $latestBlog->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $latestBlog->published_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Subscribe to Newsletter</h3>
                    <p class="text-sm text-white/90 mb-4">Get travel tips and inspiration delivered to your inbox</p>
                    
                    <form action="#" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" 
                               name="email" 
                               placeholder="Your email address" 
                               class="w-full px-4 py-2 rounded-lg text-gray-800 focus:ring-2 focus:ring-white" 
                               required>
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
@endpush
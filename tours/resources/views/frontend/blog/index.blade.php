{{-- resources/views/frontend/blog/index.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Travel Blog - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Travel Blog</h1>
        <p class="text-xl">Stories, tips, and inspiration for your Nepal journey</p>
    </div>
</section>

<!-- Blog Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Main Content -->
            <div class="lg:w-3/4">
                
                @if($blogs->count() > 0)
                    <!-- Blog Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($blogs as $blog)
                            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                                <!-- Featured Image -->
                                <div class="relative h-64">
                                    @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                             alt="{{ $blog->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-orange-400 to-pink-500"></div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    @if($blog->category)
                                        <div class="absolute top-4 left-4">
                                            <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-sm font-semibold">
                                                {{ $blog->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Blog Content -->
                                <div class="p-6">
                                    <!-- Meta Info -->
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="mr-4">📅 {{ $blog->published_at->format('M d, Y') }}</span>
                                        <span class="mr-4">👤 {{ $blog->author->name }}</span>
                                        <span>⏱️ {{ $blog->reading_time }} min read</span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h2 class="text-2xl font-bold text-gray-800 mb-3 hover:text-blue-600 transition">
                                        <a href="{{ route('blog.show', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}
                                    </p>
                                    
                                    <!-- Tags -->
                                    @if($blog->tags)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(array_slice($blog->tags, 0, 3) as $tag)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                                    #{{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Read More -->
                                    <a href="{{ route('blog.show', $blog->slug) }}" 
                                       class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition">
                                        Read More 
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <p class="text-gray-500 text-xl">No blog posts found.</p>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:w-1/4">
                
                <!-- Categories -->
                @if($categories->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 sticky top-24">
                        <h3 class="text-xl font-bold mb-4">Categories</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('blog.index') }}" 
                                   class="flex items-center justify-between text-gray-700 hover:text-blue-600 transition">
                                    <span>All Posts</span>
                                    <span class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $blogs->total() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                       class="flex items-center justify-between text-gray-700 hover:text-blue-600 transition {{ request('category') == $category->slug ? 'text-blue-600 font-semibold' : '' }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $category->blogs_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Popular Tags -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Trekking
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Everest
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Culture
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Adventure
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Nepal
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Kathmandu
                        </a>
                        <a href="#" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition">
                            #Annapurna
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection
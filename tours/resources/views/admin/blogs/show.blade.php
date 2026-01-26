@extends('admin.layouts.master')

@section('title', 'View Post')
@section('page-title', 'Post Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-64 w-full bg-gray-200 relative">
                @if($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">No Featured Image</div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold shadow-sm 
                        @if($blog->status === 'published') bg-green-100 text-green-800 
                        @elseif($blog->status === 'draft') bg-gray-100 text-gray-800 
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($blog->status) }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $blog->title }}</h1>
                
                <div class="flex items-center text-sm text-gray-500 mb-6 border-b pb-6">
                    <span class="flex items-center mr-6">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $blog->author->name }}
                    </span>
                    <span class="flex items-center mr-6">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'N/A' }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($blog->views) }} views
                    </span>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br($blog->content) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Edit Post
                </a>
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    View on Frontend
                </a>
                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-center px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition">
                        Delete Post
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Information</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Category</dt>
                    <dd class="font-medium text-gray-900">{{ $blog->category->name ?? 'Uncategorized' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Slug</dt>
                    <dd class="font-mono text-xs text-gray-600 break-all">{{ $blog->slug }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Reading Time</dt>
                    <dd class="font-medium text-gray-900">{{ $blog->reading_time }} mins</dd>
                </div>
                @if($blog->tags)
                <div>
                    <dt class="text-gray-500 mb-1">Tags</dt>
                    <dd>
                        <div class="flex flex-wrap gap-1">
                            @foreach($blog->tags as $tag)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">#{{ $tag }}</span>
                            @endforeach
                        </div>
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">SEO Preview</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Title</p>
                    <p class="text-sm font-medium">{{ $blog->meta_title ?? $blog->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Description</p>
                    <p class="text-sm text-gray-600">{{ $blog->meta_description ?? Str::limit($blog->excerpt, 100) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Show all blogs
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(9);

        // Get categories for filter
        $categories = Category::where('status', true)->get();

        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    // Show single blog
    public function show($slug)
    {
        $blog = Blog::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $blog->increment('views');

        // Get related blogs (same category)
        $relatedBlogs = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->where('category_id', $blog->category_id)
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
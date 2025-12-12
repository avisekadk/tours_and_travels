<?php
// app/Http/Controllers/Frontend/BlogController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category'])
            ->published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $blogs = $query->latest('published_at')->paginate(12);

        $categories = Category::active()
            ->whereHas('blogs')
            ->withCount('blogs')
            ->get();

        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['author', 'category'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $blog->increment('views');

        // Get related blogs
        $relatedBlogs = Blog::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $blog->id)
            ->where('category_id', $blog->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
<?php
// app/Http/Controllers/Admin/BlogController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $blogs = $query->latest()->paginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Set published_at if publishing
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        // Calculate reading time (words per minute = 200)
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = ceil($wordCount / 200);

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function show(Blog $blog)
    {
        $blog->load(['author', 'category']);

        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if ($validated['title'] !== $blog->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Set published_at if publishing for first time
        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        // Calculate reading time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = ceil($wordCount / 200);

        $blog->update($validated);

        return back()->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}
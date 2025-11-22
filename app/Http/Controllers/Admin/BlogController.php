<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Show all blogs
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('admin.blogs.create', compact('categories'));
    }

    // Store new blog
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->content = $request->content;
        $blog->excerpt = $request->excerpt;
        $blog->author_id = Auth::id();
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;

        // Set published_at if status is published
        if ($request->status === 'published' && !$blog->published_at) {
            $blog->published_at = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $blog->featured_image = $imagePath;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $blog->tags = json_encode($tags);
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }

    // Show single blog
    public function show($id)
    {
        $blog = Blog::with(['author', 'category'])->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    // Show edit form
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::where('status', true)->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    // Update blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->content = $request->content;
        $blog->excerpt = $request->excerpt;
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;

        // Set published_at if status is published
        if ($request->status === 'published' && !$blog->published_at) {
            $blog->published_at = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $blog->featured_image = $imagePath;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $blog->tags = json_encode($tags);
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }

    // Delete blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
}
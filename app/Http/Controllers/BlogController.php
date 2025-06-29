<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::latest()->paginate(12);
        return view('backend.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'is_published' => 'required|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('backend.blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $post = BlogPost::findOrFail($request->id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'is_published' => 'required|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = BlogPost::findOrFail($request->id);

        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}

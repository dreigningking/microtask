<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;

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
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:500',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'blog_' . Str::random(20) . '.' . $extension;
            $data['featured_image'] = $file->storeAs('blog', $filename, 'public');
        }

        // Convert tags string to array
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            $tags = array_filter($tags); // Remove empty tags
            $data['tags'] = $tags;
        } else {
            $data['tags'] = [];
        }

        // Handle checkboxes
        $data['featured'] = $request->has('featured');
        $data['allow_comments'] = $request->has('allow_comments');

        // Set user_id automatically
        $data['user_id'] = auth()->user()?->id;

        // Set default meta fields if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $data['meta_description'] = $data['excerpt'];
        }

        // Calculate reading time
        $data['reading_time'] = $this->calculateReadingTime($data['content']);

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Calculate reading time in minutes
     */
    private function calculateReadingTime($content)
    {
        // Strip HTML tags and count words
        $text = strip_tags($content);
        $wordCount = str_word_count($text);
        
        // Average reading speed: 200 words per minute
        $readingTime = ceil($wordCount / 200);
        
        // Minimum reading time of 1 minute
        return max(1, $readingTime);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $post)
    {
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
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:500',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $file = $request->file('featured_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'blog_' . Str::random(20) . '.' . $extension;
            $data['featured_image'] = $file->storeAs('blog', $filename, 'public');
        }

        // Convert tags string to array
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            $tags = array_filter($tags); // Remove empty tags
            $data['tags'] = $tags;
        } else {
            $data['tags'] = [];
        }

        // Handle checkboxes
        $data['featured'] = $request->has('featured');
        $data['allow_comments'] = $request->has('allow_comments');

        // Set default meta fields if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $data['meta_description'] = $data['excerpt'];
        }

        // Calculate reading time
        $data['reading_time'] = $this->calculateReadingTime($data['content']);

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

    /**
     * Get pending comments for moderation
     */
    public function pendingComments()
    {
        $comments = Comment::pending()
            ->with(['blogPost', 'user'])
            ->latest()
            ->paginate(20);

        return view('backend.comments.pending', compact('comments'));
    }

    /**
     * Approve a comment
     */
    public function approveComment(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $comment->approve();

        return back()->with('success', 'Comment approved successfully.');
    }

    /**
     * Reject a comment
     */
    public function rejectComment(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $comment->reject();

        return back()->with('success', 'Comment rejected successfully.');
    }

    /**
     * Mark comment as spam
     */
    public function markCommentAsSpam(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $comment->markAsSpam();

        return back()->with('success', 'Comment marked as spam.');
    }

    /**
     * Delete a comment
     */
    public function deleteComment(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}

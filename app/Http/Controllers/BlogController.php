<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Setting;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Apply filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('featured')) {
            $query->where('featured', '!=', null);
        }

        if ($request->filled('published_date')) {
            $query->whereDate('published_at', $request->published_date);
        }

        if ($request->filled('published_after')) {
            $query->whereDate('published_at', '>=', $request->published_after);
        }

        if ($request->filled('published_before')) {
            $query->whereDate('published_at', '<=', $request->published_before);
        }

        $posts = $query->latest()->paginate(20);
        $categories = json_decode(Setting::getValue('blog_categories'));
        
        return view('backend.blog.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = json_decode(Setting::getValue('blog_categories'));
        return view('backend.blog.create', compact('categories'));
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
            'category' => 'nullable|string|max:500',
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
        $data['featured'] = $request->has('featured') ? now() : null;
        $data['allow_comments'] = $request->has('allow_comments');

        // Set user_id automatically
        $data['user_id'] = Auth::user()?->id;

        // Set default meta fields if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $data['meta_description'] = $data['excerpt'];
        }

        // Calculate reading time
        $data['reading_time'] = $this->calculateReadingTime($data['content']);

        Post::create($data);

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
    public function edit(Post $post)
    {
        $categories = json_decode(Setting::getValue('blog_categories'));
        return view('backend.blog.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $post = Post::findOrFail($request->id);

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
            'category' => 'nullable|string|max:500',
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
        $data['featured'] = $request->has('featured') ? now() : null;
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
        $post = Post::findOrFail($request->id);

        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Display comments listing with filtering and moderation
     */
    public function comments()
    {
        $query = Comment::with(['post', 'user', 'approvedBy'])
            ->latest();

        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by blog post
        if (request('post')) {
            $query->where('post_id', request('post'));
        }

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('post', function($postQuery) use ($search) {
                      $postQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $comments = $query->paginate(20);

        // Get statistics
        $totalComments = Comment::count();
        $pendingCount = Comment::where('status', 'pending')->count();
        $approvedCount = Comment::where('status', 'approved')->count();
        $spamCount = Comment::where('status', 'spam')->count();

        // Get all blog posts for filter dropdown
        $posts = Post::select('id', 'title')->orderBy('title')->get();

        return view('backend.blog.comments', compact(
            'comments', 
            'totalComments', 
            'pendingCount', 
            'approvedCount', 
            'spamCount',
            'posts'
        ));
    }

    /**
     * Approve a comment
     */
    public function approveComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id'
        ]);

        $comment = Comment::findOrFail($request->comment_id);
        $comment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return back()->with('success', 'Comment approved successfully.');
    }

    /**
     * Reject a comment
     */
    public function rejectComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id'
        ]);

        $comment = Comment::findOrFail($request->comment_id);
        $comment->update([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => null
        ]);

        return back()->with('success', 'Comment rejected successfully.');
    }

    /**
     * Mark comment as spam
     */
    public function markCommentAsSpam(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id'
        ]);

        $comment = Comment::findOrFail($request->comment_id);
        $comment->update([
            'status' => 'spam',
            'approved_at' => null,
            'approved_by' => null
        ]);

        return back()->with('success', 'Comment marked as spam.');
    }

    /**
     * Delete a comment
     */
    public function deleteComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id'
        ]);

        $comment = Comment::findOrFail($request->comment_id);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}

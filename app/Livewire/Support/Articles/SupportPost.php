<?php

namespace App\Livewire\Support\Articles;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SupportPost extends Component
{
    public $post;
    public $title;
    public $meta_title;
    public $meta_description;
    public $categories;
    public $popularPosts;
    public $comments;
    public $commentBody = '';
    public $parentId = null;

    public function mount(Post $post)
    {
        // Ensure this is a help post
        if (!$post->category->is_help) {
            abort(404);
        }

        $this->post = $post;
        $this->post->incrementViews();

        $this->categories = Category::where('is_help', true)->withCount('posts')->get();
        $this->popularPosts = Post::help()->published()->orderBy('views_count', 'desc')->limit(3)->get();
        $this->comments = $this->post->comments()->with(['user', 'children.user'])->get();

        // Set dynamic meta tags
        $this->title = $this->post->title . ' | Wonegig Support';
        $this->meta_title = $this->post->meta_title ?: $this->post->title;
        $this->meta_description = $this->post->meta_description ?: $this->post->excerpt;
    }

    public function setReply($commentId)
    {
        $this->parentId = $commentId;
    }

    public function submitComment()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to comment.');
            return;
        }

        $this->validate([
            'commentBody' => 'required|string|max:1000',
        ]);

        Comment::create([
            'commentable_type' => Post::class,
            'commentable_id' => $this->post->id,
            'user_id' => Auth::id(),
            'parent_id' => $this->parentId,
            'body' => $this->commentBody,
        ]);

        $this->commentBody = '';
        $this->parentId = null;
        $this->comments = $this->post->comments()->with(['user', 'children.user'])->get();

        session()->flash('success', 'Comment posted successfully.');
    }

    public function render()
    {
        return view('livewire.support.articles.support-post');
    }
}

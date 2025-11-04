<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BlogComments extends Component
{
    public $post;
    public $content = '';
    public $guest_name = '';
    public $guest_email = '';
    public $showGuestFields = false;

    protected $rules = [
        'content' => 'required|string|min:3|max:2000',
        'guest_name' => 'required_if:showGuestFields,true|string|max:100',
        'guest_email' => 'required_if:showGuestFields,true|email|max:100',
    ];

    protected $messages = [
        'content.required' => 'Please enter a comment.',
        'content.min' => 'Comment must be at least 3 characters.',
        'content.max' => 'Comment cannot exceed 2000 characters.',
        'guest_name.required_if' => 'Please enter your name.',
        'guest_email.required_if' => 'Please enter your email.',
        'guest_email.email' => 'Please enter a valid email address.',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->showGuestFields = !Auth::check();
    }

    public function submitComment()
    {
        $this->validate();

        $commentData = [
            'content' => $this->content,
            'post_id' => $this->post->id,
            'status' => 'pending', // Default to pending for moderation
        ];

        // Add user info based on authentication status
        if (Auth::check()) {
            $commentData['user_id'] = Auth::id();
        } else {
            $commentData['guest_name'] = $this->guest_name;
            $commentData['guest_email'] = $this->guest_email;
        }

        // Add user agent and IP for spam detection
        $commentData['user_agent'] = request()->userAgent();
        $commentData['ip_address'] = request()->ip();

        Comment::create($commentData);

        // Reset form
        $this->reset(['content', 'guest_name', 'guest_email']);
        
        // Show success message
        session()->flash('comment_success', 'Your comment has been submitted and is awaiting approval.');
    }

    public function render()
    {
        $comments = $this->post->approvedComments()
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.blog.blog-comments', compact('comments'));
    }
} 
<?php

namespace App\Livewire\Blog;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $title = 'Blog | Wonegig';
    public $meta_title = 'Wonegig Blog - Tips, Stories & Updates';
    public $meta_description = 'Read the latest articles, tips, and platform updates from the Wonegig team.';

    public function render()
    {
        $posts = BlogPost::published()
            ->with('user')
            ->orderBy('published_at', 'desc')
            ->paginate(8);

        return view('livewire.blog.blog-index', compact('posts'));
    }
}

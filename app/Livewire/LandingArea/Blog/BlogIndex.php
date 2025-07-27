<?php

namespace App\Livewire\LandingArea\Blog;

use Livewire\Component;
use App\Models\BlogPost;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing-layout')]
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

        return view('livewire.landing-area.blog.blog-index', compact('posts'));
    }
}

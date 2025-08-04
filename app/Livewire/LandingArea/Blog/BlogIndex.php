<?php

namespace App\Livewire\LandingArea\Blog;

use App\Models\Setting;
use Livewire\Component;
use App\Models\BlogPost;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class BlogIndex extends Component
{
    use WithPagination;

    public $title = 'Blog | Wonegig';
    public $meta_title = 'Wonegig Blog - Tips, Stories & Updates';
    public $meta_description = 'Read the latest articles, tips, and platform updates from the Wonegig team.';
    public $categories = [];
    public $category;

    public function mount()
    {
        $this->category = request()->get('category');
        $this->categories = json_decode(Setting::where('name', 'blog_categories')->first()->value);
    }

    public function render()
    {
        $query = BlogPost::published()->with('user')->orderBy('published_at', 'desc');
        if (!empty($this->category)) {
            $query->where('category', $this->category);
        }
        $posts = $query->paginate(8);

        return view('livewire.landing-area.blog.blog-index', compact('posts'));
    }
}

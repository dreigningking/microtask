<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

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
        $this->categories = Category::all();
    }

    public function render()
    {
        $query = Post::with('user')->orderBy('created_at', 'desc');
        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
        }
        $posts = $query->paginate(8);

        return view('livewire.blog.blog-index', compact('posts'));
    }
}

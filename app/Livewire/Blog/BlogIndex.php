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
    public $search = '';

    public function mount()
    {
        $this->category = request()->get('category');
        $this->categories = Category::where('is_help', false)->get();
    }

    public function setCategory($categoryId)
    {
        $this->category = $categoryId;
        $this->resetPage();
    }

    public function clearCategory()
    {
        $this->category = null;
        $this->resetPage();
    }

    public function render()
    {
        $featuredPosts = Post::published()
            ->featured()
            ->whereHas('category', function ($q) {
                $q->where('is_help', false);
            })
            ->with(['user', 'category'])
            ->orderBy('featured', 'desc')
            ->take(2)
            ->get();

        $posts = Post::published()
            ->whereHas('category', function ($q) {
                $q->where('is_help', false);
            })
            ->with(['user', 'category'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('livewire.blog.blog-index', compact('posts', 'featuredPosts'));
    }
}

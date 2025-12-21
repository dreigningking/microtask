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

    public function render()
    {
        $categoryModel = null;
        if ($this->category) {
            $categoryModel = Category::where('slug', $this->category)->first();
        }

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
            ->when($categoryModel, function ($query) use ($categoryModel) {
                $query->where('category_id', $categoryModel->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('livewire.blog.blog-index', compact('posts', 'featuredPosts'));
    }
}

<?php

namespace App\Livewire\Support\Articles;

use App\Models\Post;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class SupportArticles extends Component
{
    use WithPagination;

    public $title = 'Support Articles | Wonegig';
    public $meta_title = 'Wonegig Support Articles - Help & Guides';
    public $meta_description = 'Find answers to your questions with our comprehensive support articles and guides.';
    public $categories = [];
    public $category;
    public $search = '';

    public function mount()
    {
        $this->category = request()->get('category');
        $this->categories = Category::where('is_help', true)->get();
    }

    public function render()
    {
        $categoryModel = null;
        if ($this->category) {
            $categoryModel = Category::where('slug', $this->category)->first();
        }

        $featuredPosts = Post::help()
            ->published()
            ->featured()
            ->with(['user', 'category'])
            ->orderBy('featured', 'desc')
            ->take(2)
            ->get();

        $posts = Post::help()
            ->published()
            ->with(['user', 'category'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->when($categoryModel, function ($query) use ($categoryModel) {
                $query->where('category_id', $categoryModel->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('livewire.support.articles.support-articles', compact('posts', 'featuredPosts'));
    }
}

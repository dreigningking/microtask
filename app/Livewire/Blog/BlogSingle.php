<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Setting;
use Livewire\Component;

class BlogSingle extends Component
{
    public $slug;
    public $post;
    public $title;
    public $meta_title;
    public $meta_description;
    public $categories;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->categories = json_decode(Setting::where('name', 'blog_categories')->first()->value);
        if (!$this->post) {
            abort(404);
        }

        // Set dynamic meta tags
        $this->title = $this->post->title . ' | Wonegig Blog';
        $this->meta_title = $this->post->meta_title ?: $this->post->title;
        $this->meta_description = $this->post->meta_description ?: $this->post->excerpt;
    }

    public function render()
    {
        return view('livewire.blog.blog-single');
    }
}

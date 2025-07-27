<?php

namespace App\Livewire\LandingArea\Blog;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing-layout')]
class BlogSingle extends Component
{
    public $slug;
    public $post;
    public $title;
    public $meta_title;
    public $meta_description;

    public function mount(BlogPost $post)
    {
        $this->post = $post;
        
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
        return view('livewire.landing-area.blog.blog-single');
    }
}

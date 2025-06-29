<?php

namespace App\Livewire\Blog;

use Livewire\Component;

class BlogIndex extends Component
{
    public $title = 'Blog | Wonegig';
    public $meta_title = 'Wonegig Blog - Tips, Stories & Updates';
    public $meta_description = 'Read the latest articles, tips, and platform updates from the Wonegig team.';

    public function render()
    {
        return view('livewire.blog.blog-index');
    }
}

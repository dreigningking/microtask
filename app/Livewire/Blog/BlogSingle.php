<?php

namespace App\Livewire\Blog;

use Livewire\Component;

class BlogSingle extends Component
{
    public $title = 'How to Succeed as a Freelancer | Wonegig Blog';
    public $meta_title = 'How to Succeed as a Freelancer - Wonegig Blog';
    public $meta_description = 'Learn proven strategies for freelance success on Wonegig. Tips, stories, and more.';

    public function render()
    {
        return view('livewire.blog.blog-single');
    }
}

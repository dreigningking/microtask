<?php

namespace App\Livewire;

use Livewire\Component;

class AboutPage extends Component
{
    public string $title = 'About Us | Wonegig';
    public string $meta_title = 'About Wonegig - Micro-Jobs Platform';
    public string $meta_description = 'Learn about Wonegig, our mission, values, and how we empower freelancers and businesses worldwide.';

    public function render()
    {
        return view('livewire.about-page');
    }
}

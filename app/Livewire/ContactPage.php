<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactNotification;

class ContactPage extends Component
{
    public string $pageTitle = 'Contact Us | Wonegig';
    public string $metaTitle = 'Contact Wonegig - Micro-Jobs Platform';
    public string $metaDescription = "Get in touch with the Wonegig team. We're here to help with support, partnerships, and general inquiries.";
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'subject' => 'required|string|max:150',
        'message' => 'required|string|max:2000',
    ];

    public function submitContactForm()
    {
        $this->validate();
        $contactEmail = config('app.contact_email');
        if ($contactEmail) {
            Notification::route('mail', $contactEmail)
                ->notify(new ContactNotification([
                    'name' => $this->name,
                    'email' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                ]));
            session()->flash('message', 'Your message has been sent! We will get back to you soon.');
            $this->reset(['name', 'email', 'subject', 'message']);
        } else {
            session()->flash('error', 'Contact email is not configured. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}

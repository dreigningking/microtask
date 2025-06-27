<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Wonegig!')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('Welcome to Wonegig! We are excited to have you join our community of freelancers and clients.')
            ->line('Start exploring micro-jobs, post your own, or connect with talented people today!')
            ->action('Get Started', url('/explore'))
            ->line('If you have any questions, feel free to reach out. Happy earning!');
    }
} 
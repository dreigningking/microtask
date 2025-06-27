<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EarningsNotification extends Notification
{
    use Queueable;

    protected $amount;
    protected $currency;
    protected $description;

    public function __construct($amount, $currency, $description)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You Have Earned Money!')
            ->greeting('Congratulations ' . $notifiable->name . ',')
            ->line('You have just earned ' . $this->currency . number_format($this->amount, 2) . '.')
            ->line('Earning Source: ' . $this->description)
            ->action('View Earnings', url('/my-earnings'))
            ->line('Keep up the great work!');
    }
} 
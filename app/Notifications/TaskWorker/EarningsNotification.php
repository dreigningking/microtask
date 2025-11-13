<?php

namespace App\Notifications\TaskWorker;

use App\Models\Settlement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EarningsNotification extends Notification
{
    use Queueable;

    protected $settlement;

    public function __construct(Settlement $settlement)
    {
        $this->settlement = $settlement;
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
            ->line('You have just earned ' . $this->settlement->currency . number_format($this->settlement->amount, 2) . '.')
            ->line('Earning Source: ' . $this->settlement->description)
            ->action('View Earnings', route('earnings.settlements'))
            ->line('Keep up the great work!');
    }
} 
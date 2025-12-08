<?php

namespace App\Notifications\General\Moderation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Moderation;

class BankAccountModerationNotification extends Notification
{
    use Queueable;

    public $moderation;
    public $receiver;

    public function __construct(Moderation $moderation,$receiver)
    {
        $this->moderation = $moderation;
        $this->receiver = $receiver;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $content = $this->messageContent();

        return (new MailMessage)
            ->subject($content['subject'])
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($content['body'])
            
            ->action('View', $content['url']);
    }

    public function toArray(object $notifiable): array
    {
        $content = $this->messageContent();
        return [
            'subject' => $content['subject'],
            'body' => $content['body'],
            'url' => $content['url']
        ];
    }

    public function messageContent()
    {
        $result = [];
        if ($this->receiver == 'admin') {
            $result['subject'] = 'Bank Account Moderation Needed';
            $result['body'] = 'User bank account details requires your moderation';
            $result['url'] = route('admin.users.show', $this->moderation->moderatable->user);
        } elseif ($this->moderation->status == 'approved') {
            $result['subject'] = 'Verified Bank account';
            $result['body'] = 'Your bank account has been verified';
            $result['url'] = route('profile.bank-account');
        } elseif ($this->moderation->status == 'rejected') {
            $result['subject'] = 'Your bank account verification failed';
            $result['body'] = 'Your bank account verification was not successful';
            $result['url'] = route('profile.bank-account');
        }

        return $result;
    }
} 
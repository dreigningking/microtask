<?php

namespace App\Notifications\General\Moderation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Moderation;

class UserVerificationModerationNotification extends Notification
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
            $result['subject'] = 'User Verification Moderation Needed';
            $result['body'] = $this->moderation->moderatable->document_name.' requires your moderation';
            $result['url'] = route('admin.users.verification.index', $this->moderation->moderatable);
        } elseif ($this->moderation->status == 'approved') {
            $result['subject'] = 'Your document is approved';
            $result['body'] = 'Your '.$this->moderation->moderatable->document_name.' document has been approved';
            $result['url'] = route('dashboard');
        } elseif ($this->moderation->status == 'rejected') {
            $result['subject'] = 'Your task is rejected';
            $result['body'] = 'Your '.$this->moderation->moderatable->document_name.' document has been rejected.'.$this->moderation->note;
            $result['url'] = route('profile');
        }

        return $result;
    }
} 
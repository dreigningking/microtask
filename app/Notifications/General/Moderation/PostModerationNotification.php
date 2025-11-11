<?php

namespace App\Notifications\General\Moderation;

use App\Models\Moderation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PostModerationNotification extends Notification
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
            ->line($content['intro'])
            ->line('**Comment:** ' . $content['body'])
            ->action('View Post', $content['url']);
    }

    public function toArray(object $notifiable): array
    {
        $content = $this->messageContent();
        return [
            'subject' => $content['subject'],
            'intro' => $content['intro'],
            'body' => $content['body'],
            'url' => $content['url']
        ];
    }

    public function messageContent()
    {
        $result = [];
        if ($this->receiver == 'admin') {
            $result['subject'] = 'Post Moderation Needed';
            $result['intro'] = 'A post requires your attention';
            $result['body'] = 'Title: '.$this->moderation->moderatable->title;
            $result['url'] = route('admin.blog.index');
        } elseif ($this->moderation->status == 'approved') {
            $result['subject'] = 'Your post is approved';
            $result['intro'] = 'Your post with title: ' . $this->moderation->moderatable->title . ' has been approved and listed';
            $result['body'] = 'You can attend to questions and submissions from your post dashboard';
            $result['url'] = route('blog.show', $this->moderation->moderatable);
        } elseif ($this->moderation->status == 'rejected') {
            $result['subject'] = 'Your post is rejected';
            $result['intro'] = 'Your post with title: ' . $this->moderation->moderatable->title . ' has been rejected';
            $result['body'] = $this->moderation->note;
            $result['url'] = '#';
        }

        return $result;
    }
}

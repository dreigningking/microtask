<?php

namespace App\Notifications\General\Moderation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;
use App\Models\Moderation;

class PostCommentModerationNotification extends Notification
{
    use Queueable;

    public $moderation;
    public $receiver;

    public function __construct(Moderation $moderation, $receiver)
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
        if ($this->receiver == 'author') {
            if ($this->moderation->status == 'approved') {
                $result['subject'] = 'Your comment is approved';
                $result['intro'] = 'Your comment on post with title: '.$this->moderation->moderatable->commentable->title.' has been approved and displayed';
                $result['body'] = $this->moderation->moderatable->body;
                $result['url'] = route('blog.show', $this->moderation->moderatable->commentable);
            } elseif ($this->moderation->status == 'rejected') {
                $result['subject'] = 'Your comment is rejected';
                $result['intro'] = 'Your comment on post with title: '.$this->moderation->moderatable->commentable->title.' has been rejected';
                $result['body'] = $this->moderation->note;
                $result['url'] = route('blog.show', $this->moderation->moderatable->commentable);
            }
        } else { //parent
            $result['subject'] = 'Reply to your comment';
            $result['intro'] = 'Someone replied to your comment';
            $result['body'] = $this->moderation->moderatable->body;
            $result['url'] = route('blog.show', $this->moderation->moderatable->commentable);
        }
        return $result;
    }
}

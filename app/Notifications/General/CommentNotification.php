<?php

namespace App\Notifications\General;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;

class CommentNotification extends Notification
{
    use Queueable;

    public $comment;
    public $post;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->post = $comment->post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $commenterName = $this->comment->user ? $this->comment->user->name : $this->comment->guest_name;
        
        return (new MailMessage)
            ->subject('You were mentioned in a comment on "' . $this->post->title . '"')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($commenterName . ' mentioned you in a comment on the blog post "' . $this->post->title . '".')
            ->line('**Comment:** ' . $this->comment->content)
            ->action('View Comment', route('blog.show', $this->post->slug) . '#comment-' . $this->comment->id)
            ->line('Thank you for being part of our community!');
    }
} 
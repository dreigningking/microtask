<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;
use App\Models\BlogPost;

class CommentMentionNotification extends Notification
{
    use Queueable;

    public $comment;
    public $blogPost;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->blogPost = $comment->blogPost;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $commenterName = $this->comment->user ? $this->comment->user->name : $this->comment->guest_name;
        
        return (new MailMessage)
            ->subject('You were mentioned in a comment on "' . $this->blogPost->title . '"')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($commenterName . ' mentioned you in a comment on the blog post "' . $this->blogPost->title . '".')
            ->line('**Comment:** ' . $this->comment->content)
            ->action('View Comment', route('blog.show', $this->blogPost->slug) . '#comment-' . $this->comment->id)
            ->line('Thank you for being part of our community!');
    }
} 
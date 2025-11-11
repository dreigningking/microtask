<?php

namespace App\Notifications\General\Comments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;

class SupportCommentNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

     public function via($notifiable){
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = $notifiable->role_id ? 
                route('support.tickets.show',$this->comment->commentable) :
                route('support.ticket',$this->comment->commentable);

        return (new MailMessage)
            ->subject('Support Ticket: '.$this->comment->commentable->id)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->comment->body)
            ->action('Reply', $url);
    }

    
} 
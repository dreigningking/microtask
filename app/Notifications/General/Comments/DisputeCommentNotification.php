<?php

namespace App\Notifications\General\Comments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;

class DisputeCommentNotification extends Notification
{
    use Queueable;

    public $comment;
    public $sender;
    

    public function __construct(Comment $comment,$sender)
    {
        $this->comment = $comment;
        $this->sender = $sender;
    }

     public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        $content = $this->messageContent($notifiable);
        
        return (new MailMessage)
            ->subject('Dispute Resolution')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have a dispute message from '.$content['sender'])
            ->action('Manage Dispute', $content['url']);
    }

    public function toArray(object $notifiable): array
    {
        $content = $this->messageContent($notifiable);
        return [
            'subject' => 'Dispute Resolution',
            'body' => 'You have a dispute message from '.$content['sender'],
            'url'=> $content['url']
        ];
    }

    public function messageContent($user){
        $result = [];
        
        if($this->sender == 'admin'){
            $result['sender'] = 'Admin';
            $result['url'] = route('tasks.dispute',$this->comment->commentable);
        }elseif($this->sender == 'worker'){
            $result['sender'] = 'Task Worker';
            $result['url'] = $user->role_id ? 
                                route('admin.support.disputes.index') :
                                route('tasks.dispute',$this->comment->commentable);
        }else{
            $result['sender'] = 'Task Creator';
            $result['url'] = $user->role_id ? 
                                route('admin.support.disputes.index') :
                                route('tasks.dispute',$this->comment->commentable);
        }
        return $result;
    }
} 
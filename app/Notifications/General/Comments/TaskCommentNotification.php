<?php

namespace App\Notifications\General\Comments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Comment;

class TaskCommentNotification extends Notification
{
    use Queueable;

    public $comment;
    public $receiver;
    public $flagged;

    public function __construct(Comment $comment,$receiver,$flagged = false)
    {
        $this->comment = $comment;
        $this->receiver = $receiver;
        $this->flagged = $flagged;
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        $content = $this->messageContent();
        
        return (new MailMessage)
            ->subject($content['subject'])
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($content['intro'])
            ->line('**Comment:** ' . $this->comment->body)
            ->action('View Task', $content['url']);
    }

    public function toArray(object $notifiable): array
    {
        $content = $this->messageContent();
        return [
            'subject' => $content['subject'],
            'intro' => $content['intro'],
            'body'=> $this->comment->body,
            'url'=> $content['url']
        ];
    }

    public function messageContent(){
        $result = [];
        if($this->flagged){
            if($this->receiver == 'admin'){
                $result['subject'] = 'Task Flagged on Wonegig';
                $result['intro'] = 'Task with title'.$this->comment->commentable->title.' has been flagged. The details reported are as follows:';
                $result['url'] = route('admin.tasks.show',$this->comment->commentable);
            }else{
                $result['subject'] = 'Task with title'.$this->comment->commentable->title.' has been flagged. The details reported are as follows:';
                $result['intro'] = '';
                $result['url'] = route('tasks.posted',$this->comment->commentable);
            }
        }else{
            if($this->receiver == 'author'){
                $result['subject'] = 'You have a question on your task to answer';
                $result['intro'] = 'Someone has asked a question on your task with title: '.$this->comment->commentable->title;
                $result['url'] = route('tasks.posted',$this->comment->commentable);
            }else{ //parent
                $result['subject'] = 'Your Question was Answered';
                $result['intro'] = 'Question: '.$this->comment->parent->body;             
                $result['url'] = route('explore.task',$this->comment->commentable);
            }
        }
        return $result;
    }
} 
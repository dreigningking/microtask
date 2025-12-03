<?php

namespace App\Notifications\General\Moderation;

use App\Models\Moderation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskModerationNotification extends Notification
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
            ->action('Manage Task', $content['url']);
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
            $result['subject'] = 'Task Moderation Needed';
            $result['intro'] = 'A task requires your attention';
            $result['body'] = 'Title: '.$this->moderation->moderatable->title;
            $result['url'] = route('admin.tasks.show', $this->moderation->moderatable);
        } elseif ($this->moderation->status == 'approved') {
            $result['subject'] = 'Your task is approved';
            $result['intro'] = 'Your task with title: ' . $this->moderation->moderatable->title . ' has been approved and listed';
            $result['body'] = 'You can attend to questions and submissions from your task dashboard';
            $result['url'] = route('tasks.posted', $this->moderation->moderatable);
        } elseif ($this->moderation->status == 'rejected') {
            $result['subject'] = 'Your task is rejected';
            $result['intro'] = 'Your task with title: ' . $this->moderation->moderatable->title . ' has been rejected';
            $result['body'] = $this->moderation->note;
            $result['url'] = route('tasks.posted', $this->moderation->moderatable);
        }

        return $result;
    }
}

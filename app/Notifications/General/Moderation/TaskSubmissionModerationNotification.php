<?php

namespace App\Notifications\General\Moderation;

use App\Models\Moderation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskSubmissionModerationNotification extends Notification
{
    use Queueable;

    public $moderation;

    public function __construct(Moderation $moderation)
    {
        $this->moderation = $moderation;
        
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
            ->action('Manage Submission', $content['url']);
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
        $result['subject'] = 'Task Submission Moderation Needed';
        $result['body'] = 'A task submission requires your review. Please check the submission and take appropriate action.';
        $result['url'] = route('admin.tasks.review_submission', $this->moderation->moderatable);
        return $result;
    }
}

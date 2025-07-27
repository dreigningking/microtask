<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class JobApprovedNotification extends Notification
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Job Has Been Approved!')
            ->greeting('Congratulations 🎉')
            ->line('Your job posting "' . $this->task->title . '" has been reviewed and approved by our team.')
            ->line('Your job is now live and visible to qualified users on Wonegig.')
            ->action('View Job', url(route('jobs.view', $this->task->id)))
            ->line('Thank you for choosing Wonegig to get work done, faster and smarter!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'message' => 'Your job "' . $this->task->title . '" has been approved and is now live!',
            'url' => url(route('jobs.view', $this->task->id)),
        ];
    }
}
<?php

namespace App\Notifications\TaskWorker;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class BroadcastTaskPromotionNotification extends Notification
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
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $showUrl = route('explore.task', $this->task);
        return (new MailMessage)
            ->subject($this->task->title)
            ->greeting('Task Alert!')
            ->line('A new task has just been posted on the platform that matches your interests and location.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Budget:** ' . ($this->task->user->country->currency_symbol ?? '$') . number_format($this->task->budget_per_submission, 2))
            ->line('**Description:** ')
            ->line(substr(strip_tags($this->task->description), 0, 200) . (strlen($this->task->description) > 200 ? '...' : ''))
            ->action('View Task & Apply Now', $showUrl)
            ->line('This is a limited opportunity. If you are interested, please apply as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TaskInviteNotification extends Notification
{
    use Queueable;

    protected Task $task;

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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('explore.task', $this->task);
        $inviterName = $this->task->user->name ?? 'A user';
        $reward = ($this->task->user->country->currency_symbol ?? '$') . number_format($this->task->budget_per_submission, 2);

        return (new MailMessage)
            ->subject("You've Been Invited to a Task: " . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("$inviterName has invited you to complete a task on our platform and earn **$reward**.")
            ->line('This is a great opportunity to use your skills.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Description:** ' . Str::limit($this->task->description, 150))
            ->action('View Task Details', $url)
            ->line('Please note that this invitation will expire. We encourage you to view the task soon.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => 'You have been invited to a new task by ' . ($this->task->user->name ?? 'a user') . '.',
            'url' => route('explore.task', $this->task),
        ];
    }
}

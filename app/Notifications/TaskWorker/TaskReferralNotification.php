<?php

namespace App\Notifications\TaskWorker;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskReferralNotification extends Notification
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
        $referrerName = $this->task->user->name ?? 'A user';
        $reward = ($this->task->user->currency_symbol ?? '$') . number_format($this->task->budget_per_submission, 2);

        return (new MailMessage)
            ->subject("A Task has been recommended to you: " . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("$referrerName has referred you to complete a task on our platform and earn **$reward**.")
            ->line('This is a great opportunity to use your skills.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Description:** ' . Str::limit($this->task->description, 150))
            ->action('View Task Details', $url)
            ->line('Please note that this task is timebound. We encourage you to view the task soon.');
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
            'message' => 'You have been referred to a new task by ' . ($this->task->user->name ?? 'a user') . '.',
            'url' => route('explore.task', $this->task),
        ];
    }
}

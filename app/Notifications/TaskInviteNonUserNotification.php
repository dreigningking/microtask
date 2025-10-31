<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TaskInviteNonUserNotification extends Notification
{
    use Queueable;

    protected Task $task;
    protected string $email;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, string $email)
    {
        $this->task = $task;
        $this->email = $email;
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
        $registerUrl = url('/register?invite_task=' . $this->task->id . '&email=' . urlencode($this->email));
        $inviterName = $this->task->user->name ?? 'A user';
        $reward = ($this->task->user->country->currency_symbol ?? '$') . number_format($this->task->budget_per_submission, 2);

        return (new MailMessage)
            ->subject("Invitation to Join Our Platform & Earn")
            ->greeting('Hello,')
            ->line("$inviterName has invited you to join our platform to complete a task and earn **$reward**.")
            ->line("This is a great opportunity to start earning by completing simple tasks.")
            ->line('**Task:** ' . $this->task->title)
            ->line('**Description:** ' . Str::limit($this->task->description, 150))
            ->action('Accept Invitation & Register', $registerUrl)
            ->line('Click the button above to create your account and get started on the task. This invitation will expire.');
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

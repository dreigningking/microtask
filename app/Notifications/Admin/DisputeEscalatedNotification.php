<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TaskDispute;
use App\Models\TaskSubmission;

class DisputeEscalatedNotification extends Notification
{
    use Queueable;

    public $dispute;
    public $taskSubmission;

    public function __construct(TaskDispute $dispute, TaskSubmission $taskSubmission)
    {
        $this->dispute = $dispute;
        $this->taskSubmission = $taskSubmission;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = route('admin.tasks.review_submission', $this->taskSubmission);

        return (new MailMessage)
            ->subject('Dispute Escalated: Task #' . $this->taskSubmission->task_id)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A dispute has been escalated to you for review.')
            ->line('**Task:** ' . $this->taskSubmission->task->title)
            ->line('**Submission ID:** ' . $this->taskSubmission->id)
            ->line('**Dispute Reason:** ' . $this->dispute->outcome)
            ->action('Review Dispute', $url)
            ->line('Please attend to this dispute as soon as possible.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Dispute Escalated',
            'message' => 'A dispute for Task #' . $this->taskSubmission->task_id . ' has been escalated to you.',
            'url' => route('admin.tasks.review_submission', $this->taskSubmission),
            'type' => 'dispute_escalated',
        ];
    }
}
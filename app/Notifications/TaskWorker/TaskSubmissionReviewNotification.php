<?php

namespace App\Notifications\TaskWorker;

use App\Models\TaskSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskSubmissionReviewNotification extends Notification
{
    use Queueable;
    public $taskSubmission;
    /**
     * Create a new notification instance.
     */
    public function __construct(TaskSubmission $taskSubmission)
    {
        $this->taskSubmission = $taskSubmission;
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
        $taskSubmission = $this->taskSubmission;
        $task = $taskSubmission->task;

        $mail = (new MailMessage)
            ->subject($taskSubmission->accepted ? 'Congratulations! Your submission was approved' : 'Submission Review Update');

        if ($taskSubmission->accepted) {
            $mail->greeting('Congratulations!')
                ->line('Your submission for the task "' . $task->title . '" has been approved!');

            if ($taskSubmission->review_body) {
                $mail->line('Review: ' . $taskSubmission->review_body);
            }

            if (!$taskSubmission->taskWorker->submission_restricted_at) {
                if ($task->allow_multiple_submissions) {
                    $mail->line('Since this task allows multiple submissions, feel free to submit more work to earn additional rewards!');
                } else {
                    $mail->line('Share this task with others to earn referral bonuses when they complete it!');
                }
            }
        } else {
            $mail->greeting('Submission Review Update')
                ->line('Your submission for the task "' . $task->title . '" has been reviewed.');

            if ($taskSubmission->review_body) {
                $mail->line('Review: ' . $taskSubmission->review_body);
            }

            if (!$taskSubmission->taskWorker->submission_restricted_at) {
                if ($task->allow_multiple_submissions) {
                    $mail->line('You can try submitting again to improve your work.');
                } else {
                    $mail->line('You can resubmit your work for another review.');
                }
            }
        }

        $mail->action('View Task', route('explore.task',$task))
            ->line('Thank you for participating!');

        return $mail;
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

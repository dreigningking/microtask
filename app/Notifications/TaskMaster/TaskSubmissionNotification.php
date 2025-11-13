<?php

namespace App\Notifications\TaskMaster;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use App\Models\TaskSubmission;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskSubmissionNotification extends Notification
{
    use Queueable;

    protected $taskSubmission;

    public function __construct(TaskSubmission $taskSubmission)
    {
        $this->taskSubmission = $taskSubmission;

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $deadline = null;
        $setting = Setting::where('name','submission_review_deadline')->first();
        if($setting && $setting->value){
            $deadline = $this->taskSubmission->created_at->addDay(intval($setting->value));
        }
        return (new MailMessage)
            ->subject('Task Submission')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have a task submission that requires your review on task with title: '. $this->taskSubmission->task->title)
            ->action('Review Submission', url(route('tasks.manage', $this->taskSubmission->task)))
            ->line($deadline ? 'Please review the submission before the deadline '.$deadline->format('d-M-Y'): '');
    }
} 
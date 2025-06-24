<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $worker;

    public function __construct($task, $worker)
    {
        $this->task = $task;
        $this->worker = $worker;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('A Worker Has Submitted a Job')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->worker->name . ' has submitted their work for your task: "' . $this->task->title . '".')
            ->action('Review Submission', url(route('my_jobs.view', $this->task)))
            ->line('Please review the submission and take the appropriate action.');
    }
} 
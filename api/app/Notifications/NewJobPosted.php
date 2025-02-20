<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Job;
use Illuminate\Support\HtmlString;

class NewJobPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $job;

    /**
     * Create a new notification instance.
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Send via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Job Submission for Approval')
            ->line('A new job has been submitted for approval.')
            ->line('Title: ' . $this->job->title)
            ->line('From: ' . $this->job->contact_email)
            ->line('Description: ')
            ->line($this->job->description)
            ->action('Approve Job', url('/jobs/' . $this->job->id . '/approve'))
            ->line('If this job is spam, click the link below:')
            ->line(new HtmlString('<a href="'.url('/jobs/' . $this->job->id . '/spam').'" style="display:block; margin: 0 auto; width: 180px;">Mark as Spam</a>'))
            ->line('Thank you for managing job submissions!');
    }
}
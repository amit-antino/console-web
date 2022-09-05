<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct($job)
    {
        $this->data = $job;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/reports/experiment/' . ___encrypt($this->data->id) . '?report_type=' . ___encrypt($this->data->report_type));
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('Report Genreted Succesfully !')
            ->action('View Report', $url)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}

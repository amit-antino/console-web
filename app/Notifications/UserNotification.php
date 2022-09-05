<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    public $offerData;

    public function __construct($job)
    {
        $this->offerData = $job;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' =>  $this->offerData,
        ];
    }
}

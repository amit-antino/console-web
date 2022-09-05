<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mail_details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_details)
    {

        $this->mail_details = $mail_details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($mail_details);

        // $user = $this->mail_details['user'];
        // $url = $this->mail_details['url'];
        // $name = $this->mail_details['name'];
        // $email = $this->mail_details['email'];
        // $title = $this->mail_details['title'];
        // $otp = $this->mail_details['otp'];
        // $user =  $this->mail_details['user'];
        // Mail::send('email_templates.two_factor_otp', ['name' => $name, 'url' => $url, 'email' => $email, 'title' => $title, 'otp' => $otp], function ($message) use ($user) {
        //     $message->to($user->email)->subject('Two Factor Authentication OTP');
        // });
    }
}

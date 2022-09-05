<?php

namespace App\Observers;

use App\Models\Report\ProcessComaprison;;

use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\EmailNotification;

class ProcessComaprisonObserver
{
    public function created(ProcessComaprison $processComaprison)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processComaprison->report_name,
            'id' => $processComaprison->id,
            'msg' => 'Process Comparision Report Created ' . $processComaprison->report_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ProcessComaprison $processComaprison)
    {
    }

    public function deleted(ProcessComaprison $processComaprison)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processComaprison->report_name,
            'id' => $processComaprison->id,
            'msg' => 'Process Comparision Report Deleted ' . $processComaprison->report_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ProcessComaprison $processComaprison)
    {
    }

    public function forceDeleted(ProcessComaprison $processComaprison)
    {
    }
}

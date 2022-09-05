<?php

namespace App\Observers;

use App\Models\Report\ExperimentReport;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Http;
use App\Jobs\GetProcessExpReport;

class ExperimentReportObserver
{
    public function created(ExperimentReport $experimentReport)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $experimentReport->name,
            'id' => $experimentReport->id,
            'msg' => 'Experiment Report Generated Successfully ' . $experimentReport->name
        ];
        $userSchema->notify(new UserNotification($data));
        // GetProcessExpReport::dispatch($experimentReport)->delay(now()->addSeconds(5));
    }

    public function updated(ExperimentReport $experimentReport)
    {
        // $user_id = Auth::user()->id;
        // $userSchema = User::find($user_id);
        // $data = [
        //     'name' => $experimentReport->name,
        //     'id' => $experimentReport->id,
        //     'msg' => 'Experiment Report Created Successfully ' . $experimentReport->name
        // ];
        // $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ExperimentReport $experimentReport)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $experimentReport->name,
            'id' => $experimentReport->id,
            'msg' => 'Experiment Report Deleted ' . $experimentReport->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ExperimentReport $experimentReport)
    {
    }

    public function forceDeleted(ExperimentReport $experimentReport)
    {
    }
}

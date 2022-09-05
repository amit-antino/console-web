<?php

namespace App\Observers;


use App\Models\Report\ProcessAnalysisReport;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Http;
use App\Notifications\EmailNotification;

class ProcessAnalysisReportObserver
{
    public function created(ProcessAnalysisReport $processAnalysisReport)
    {
        
        
    }

    public function updated(ProcessAnalysisReport $processAnalysisReport)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);

        $data = [
            'name' => $processAnalysisReport->report_name,
            'id' => $processAnalysisReport->id,
            'msg' => 'Process Analysis Report Genreted ' . $processAnalysisReport->report_name,
        ];
        $userSchema->notify(new UserNotification($data));
        //Notification::send($userSchema, new EmailNotification($processAnalysisReport));
    }

    public function deleted(ProcessAnalysisReport $processAnalysisReport)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processAnalysisReport->report_name,
            'id' => $processAnalysisReport->id,
            'msg' => 'Process Analysis Report Deleted ' . $processAnalysisReport->report_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ProcessAnalysisReport $processAnalysisReport)
    {
    }

    public function forceDeleted(ProcessAnalysisReport $processAnalysisReport)
    {
    }
}

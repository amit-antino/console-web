<?php

namespace App\Observers;

use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProcessExpProfileMasterObserver
{
    public function created(ProcessExpProfileMaster $processExpProfileMaster)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfileMaster->experiment->process_experiment_name,
            'id' => $processExpProfileMaster->id,
            'msg' => 'Experiment Master Profile Created  ' . $processExpProfileMaster->experiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProcessExpProfileMaster $processExpProfileMaster)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfileMaster->experiment->process_experiment_name,
            'id' => $processExpProfileMaster->id,
            'msg' => 'Experiment Master Profile Updated  ' . $processExpProfileMaster->experiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProcessExpProfileMaster $processExpProfileMaster)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfileMaster->experiment->process_experiment_name,
            'id' => $processExpProfileMaster->id,
            'msg' => 'Experiment Master Profile Deleted  ' . $processExpProfileMaster->experiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProcessExpProfileMaster $processExpProfileMaster)
    {
    }
    
    public function forceDeleted(ProcessExpProfileMaster $processExpProfileMaster)
    {
    }
}

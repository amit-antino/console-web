<?php

namespace App\Observers;

use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProcessExpProfileObserver
{
    public function created(ProcessExpProfile $processExpProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfile->process_experiment_info->process_experiment_name,
            'id' => $processExpProfile->id,
            'msg' => 'Experiment Profile Created  ' . $processExpProfile->process_experiment_info->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProcessExpProfile $processExpProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfile->process_experiment_info->process_experiment_name,
            'id' => $processExpProfile->id,
            'msg' => 'Experiment Profile Updated  ' . $processExpProfile->process_experiment_info->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProcessExpProfile $processExpProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'process_experiment' => $processExpProfile->process_experiment_info->process_experiment_name,
            'id' => $processExpProfile->id,
            'msg' => 'Experiment Profile Deleted ' . $processExpProfile->process_experiment_info->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProcessExpProfile $processExpProfile)
    {
    }
    
    public function forceDeleted(ProcessExpProfile $processExpProfile)
    {
    }
}

<?php

namespace App\Observers;

use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProcessExperimentObserver
{
    public function created(ProcessExperiment $processExperiment)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExperiment->process_experiment_name,
            'id' => $processExperiment->id,
            'msg' => 'Experiment Created ' . $processExperiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ProcessExperiment $processExperiment)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExperiment->process_experiment_name,
            'id' => $processExperiment->id,
            'msg' => 'Experiment Updated ' . $processExperiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ProcessExperiment $processExperiment)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExperiment->process_experiment_name,
            'id' => $processExperiment->id,
            'msg' => 'Experiment Deleted ' . $processExperiment->process_experiment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ProcessExperiment $processExperiment)
    {
    }

    public function forceDeleted(ProcessExperiment $processExperiment)
    {
    }
}

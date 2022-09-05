<?php

namespace App\Observers;

use App\Models\ProcessExperiment\ProcessExpEnergyFlow;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;


class ProcessExpEnergyFlowObserver
{
    public function created(ProcessExpEnergyFlow $processExpEnergyFlow)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExpEnergyFlow->name,
            'process_experiment' => $processExpEnergyFlow->getExp->process_experiment_name,
            'id' => $processExpEnergyFlow->id,
            'msg' => 'Process EnergyFlow  Created for Experiment ' . $processExpEnergyFlow->getExp->process_experiment_name . ' - ' . $processExpEnergyFlow->stream_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProcessExpEnergyFlow $processExpEnergyFlow)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExpEnergyFlow->name,
            'process_experiment' => $processExpEnergyFlow->getExp->process_experiment_name,
            'id' => $processExpEnergyFlow->id,
            'msg' => 'Process EnergyFlow  Updated for Experiment ' . $processExpEnergyFlow->getExp->process_experiment_name . ' - ' . $processExpEnergyFlow->stream_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProcessExpEnergyFlow $processExpEnergyFlow)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processExpEnergyFlow->name,
            'process_experiment' => $processExpEnergyFlow->getExp->process_experiment_name,
            'id' => $processExpEnergyFlow->id,
            'msg' => 'Process EnergyFlow  Deleted for Experiment ' . $processExpEnergyFlow->getExp->process_experiment_name . ' - ' . $processExpEnergyFlow->stream_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProcessExpEnergyFlow $processExpEnergyFlow)
    {
    }
    
    public function forceDeleted(ProcessExpEnergyFlow $processExpEnergyFlow)
    {
    }
}

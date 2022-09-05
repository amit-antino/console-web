<?php

namespace App\Observers;

use App\Models\ProcessExperiment\SimulateDataset;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class SimulateDatasetObserver
{
    public function created(SimulateDataset $simulateDataset)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $simulateDataset->config_name,
            'process_experiment' => $simulateDataset->experiment->process_experiment_name,
            'id' => $simulateDataset->id,
            'msg' => 'Experiment Simulation Dataset Created ' . $simulateDataset->experiment->process_experiment_name . '-' . $simulateDataset->config_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(SimulateDataset $simulateDataset)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $simulateDataset->config_name,
            'process_experiment' => $simulateDataset->experiment->process_experiment_name,
            'id' => $simulateDataset->id,
            'msg' => 'Experiment Simulation Dataset Updated ' . $simulateDataset->experiment->process_experiment_name . '-' . $simulateDataset->config_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(SimulateDataset $simulateDataset)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $simulateDataset->config_name,
            'process_experiment' => $simulateDataset->experiment->process_experiment_name,
            'id' => $simulateDataset->id,
            'msg' => 'Experiment Simulation Dataset Deleted ' . $simulateDataset->experiment->process_experiment_name . '-' . $simulateDataset->config_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(SimulateDataset $simulateDataset)
    {
    }
    
    public function forceDeleted(SimulateDataset $simulateDataset)
    {
    }
}

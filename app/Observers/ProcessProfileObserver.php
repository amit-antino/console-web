<?php

namespace App\Observers;

use App\Models\MFG\ProcessProfile;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProcessProfileObserver
{
    public function created(ProcessProfile $processProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processProfile->SimulationType->simulation_name,
            'process_simulation' => $processProfile->processSimulation->process_name,
            'id' => $processProfile->id,
            'msg' => 'Process Simulation Profile Created for ' . $processProfile->processSimulation->process_name . ' with simulation type ' . $processProfile->SimulationType->simulation_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ProcessProfile $processProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processProfile->SimulationType->simulation_name,
            'process_simulation' => $processProfile->processSimulation->process_name,
            'id' => $processProfile->id,
            'msg' => 'Process Simulation Profile Updated for ' . $processProfile->processSimulation->process_name . ' with simulation type ' . $processProfile->SimulationType->simulation_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ProcessProfile $processProfile)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processProfile->SimulationType->simulation_name,
            'process_simulation' => $processProfile->processSimulation->process_name,
            'id' => $processProfile->id,
            'msg' => 'Process Simulation Profile Deleted for ' . $processProfile->processSimulation->process_name . ' with simulation type ' . $processProfile->SimulationType->simulation_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ProcessProfile $processProfile)
    {
    }

    public function forceDeleted(ProcessProfile $processProfile)
    {
    }
}

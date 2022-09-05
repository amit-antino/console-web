<?php

namespace App\Observers;

use App\Models\MFG\ProcessSimulation;
use Illuminate\Support\Facades\Log;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProcessSimulationObserver
{
    public function created(ProcessSimulation $processSimulation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processSimulation->process_name,
            'id' => $processSimulation->id,
            'msg' => 'Process Simulation Created' . $processSimulation->process_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProcessSimulation $processSimulation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processSimulation->process_name,
            'id' => $processSimulation->id,
            'msg' => 'Process Simulation Updated ' . $processSimulation->process_name,
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProcessSimulation $processSimulation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processSimulation->process_name,
            'id' => $processSimulation->id,
            'msg' => 'Process Simulation Deleted ' . $processSimulation->process_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProcessSimulation $processSimulation)
    {
    }
    
    public function forceDeleted(ProcessSimulation $processSimulation)
    {
    }
}

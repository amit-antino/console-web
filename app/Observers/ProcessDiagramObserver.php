<?php

namespace App\Observers;

use App\Models\Experiment\ProcessDiagram;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;


class ProcessDiagramObserver
{
    public function created(ProcessDiagram $processDiagram)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processDiagram->name,
            'process_experiment' => $processDiagram->getExp->process_experiment_name,
            'id' => $processDiagram->id,
            'msg' => 'Process Diagram  Created for  for Experiment  ' . $processDiagram->getExp->process_experiment_name . ' - ' . $processDiagram->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProcessDiagram $processDiagram)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processDiagram->name,
            'process_experiment' => $processDiagram->getExp->process_experiment_name,
            'id' => $processDiagram->id,
            'msg' => 'Process Diagram  Updated for for Experiment ' . $processDiagram->getExp->process_experiment_name . ' - ' . $processDiagram->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProcessDiagram $processDiagram)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $processDiagram->name,
            'process_experiment' => $processDiagram->getExp->process_experiment_name,
            'id' => $processDiagram->id,
            'msg' => 'Process Diagram  Deleted for Experiment ' . $processDiagram->getExp->process_experiment_name . ' - ' . $processDiagram->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProcessDiagram $processDiagram)
    {
    }
    
    public function forceDeleted(ProcessDiagram $processDiagram)
    {
    }
}

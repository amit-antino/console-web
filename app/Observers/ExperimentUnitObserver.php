<?php

namespace App\Observers;

use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ExperimentUnitObserver
{
    public function created(ExperimentUnit $experimentUnit)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $experimentUnit->experiment_unit_name,
            'id' => $experimentUnit->id,
            'msg' => 'Experiment Unit Created ' . $experimentUnit->experiment_unit_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ExperimentUnit $experimentUnit)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $experimentUnit->name,
            'id' => $experimentUnit->id,
            'msg' => 'Experiment Unit Updated ' . $experimentUnit->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ExperimentUnit $experimentUnit)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $experimentUnit->name,
            'id' => $experimentUnit->id,
            'msg' => 'Experiment Unit Deleted ' . $experimentUnit->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ExperimentUnit $experimentUnit)
    {
    }

    public function forceDeleted(ExperimentUnit $experimentUnit)
    {
    }
}

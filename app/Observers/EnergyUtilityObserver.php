<?php

namespace App\Observers;

use App\Models\OtherInput\EnergyUtility;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class EnergyUtilityObserver
{
    public function created(EnergyUtility $energyUtility)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtility->energy_name,
            'id' => $energyUtility->id,
            'msg' => 'Energy Utility Created ' . $energyUtility->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(EnergyUtility $energyUtility)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtility->energy_name,
            'id' => $energyUtility->id,
            'msg' => 'Energy Utility Updated ' . $energyUtility->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(EnergyUtility $energyUtility)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtility->energy_name,
            'id' => $energyUtility->id,
            'msg' => 'Energy Utility Deleted ' . $energyUtility->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(EnergyUtility $energyUtility)
    {
    }
    
    public function forceDeleted(EnergyUtility $energyUtility)
    {
    }
}

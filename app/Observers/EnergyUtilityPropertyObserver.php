<?php

namespace App\Observers;

use App\Models\OtherInput\EnergyUtilityProperty;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class EnergyUtilityPropertyObserver
{
    public function created(EnergyUtilityProperty $energyUtilityProperty)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtilityProperty->getenergy->energy_name,
            'id' => $energyUtilityProperty->id,
            'msg' => 'Energy Utility Property Created - ' . $energyUtilityProperty->getenergy->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(EnergyUtilityProperty $energyUtilityProperty)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtilityProperty->getenergy->energy_name,
            'id' => $energyUtilityProperty->id,
            'msg' => 'Energy Utility Property Updated - ' . $energyUtilityProperty->getenergy->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(EnergyUtilityProperty $energyUtilityProperty)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $energyUtilityProperty->getenergy->energy_name,
            'id' => $energyUtilityProperty->id,
            'msg' => 'Energy Utility Property Deleted - ' . $energyUtilityProperty->getenergy->energy_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(EnergyUtilityProperty $energyUtilityProperty)
    {
    }

    public function forceDeleted(EnergyUtilityProperty $energyUtilityProperty)
    {
    }
}

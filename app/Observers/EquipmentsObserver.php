<?php

namespace App\Observers;

use App\Models\OtherInput\Equipments;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class EquipmentsObserver
{
    public function created(Equipments $equipments)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $equipments->equipment_name,
            'id' => $equipments->id,
            'msg' => 'Equipment Created ' . $equipments->equipment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(Equipments $equipments)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $equipments->equipment_name,
            'id' => $equipments->id,
            'msg' => 'Equipment updated ' . $equipments->equipment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(Equipments $equipments)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $equipments->equipment_name,
            'id' => $equipments->id,
            'msg' => 'Equipment Deleted ' . $equipments->equipment_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(Equipments $equipments)
    {
    }
    
    public function forceDeleted(Equipments $equipments)
    {
    }
}

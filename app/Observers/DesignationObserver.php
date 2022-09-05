<?php

namespace App\Observers;

use App\Models\Organization\Users\Designation;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class DesignationObserver
{
    public function created(Designation $designation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $designation->name,
            'id' => $designation->id,
            'msg' => 'Designation Created ' . $designation->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(Designation $designation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $designation->name,
            'id' => $designation->id,
            'msg' => 'Designation Updated ' . $designation->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(Designation $designation)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $designation->name,
            'id' => $designation->id,
            'msg' => 'Designation Deleted ' . $designation->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(Designation $designation)
    {
    }
    
    public function forceDeleted(Designation $designation)
    {
    }
}

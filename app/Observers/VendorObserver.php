<?php

namespace App\Observers;

use App\Models\Organization\Vendor\Vendor;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class VendorObserver
{
    public function created(Vendor $vendor)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $vendor->name,
            'id' => $vendor->id,
            'msg' => 'Vendor Created ' . $vendor->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(Vendor $vendor)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $vendor->name,
            'id' => $vendor->id,
            'msg' => 'Vendor Updated ' . $vendor->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(Vendor $vendor)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $vendor->name,
            'id' => $vendor->id,
            'msg' => 'Vendor Deleted ' . $vendor->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(Vendor $vendor)
    {
    }

    public function forceDeleted(Vendor $vendor)
    {
    }
}

<?php

namespace App\Observers;

use App\Models\Models\ModelDetail;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;


class ModelDetailObserver
{
    public function created(ModelDetail $modelDetail)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $modelDetail->name,
            'id' => $modelDetail->id,
            'msg' => 'Model Created ' . $modelDetail->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ModelDetail $modelDetail)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $modelDetail->name,
            'id' => $modelDetail->id,
            'msg' => 'Model Updated ' . $modelDetail->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ModelDetail $modelDetail)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $modelDetail->name,
            'id' => $modelDetail->id,
            'msg' => 'Model Deleted ' . $modelDetail->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ModelDetail $modelDetail)
    {
    }

    public function forceDeleted(ModelDetail $modelDetail)
    {
    }
}

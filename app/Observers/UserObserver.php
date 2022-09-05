<?php

namespace App\Observers;


use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class UserObserver
{
    public function created(User $user)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $user->first_name,
            'id' => $user->id,
            'msg' => 'User Created ' . $user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(User $user)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $user->first_name,
            'id' => $user->id,
            'msg' => 'User Updated ' . $user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(User $user)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $user->first_name,
            'id' => $user->id,
            'msg' => 'User deleted ' . $user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(User $user)
    {
    }

    public function forceDeleted(User $user)
    {
    }
}

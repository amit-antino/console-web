<?php

namespace App\Observers;

use App\Models\OtherInput\Reaction;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ReactionObserver
{
    public function created(Reaction $reaction)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $reaction->reaction_name,
            'id' => $reaction->id,
            'msg' => 'Reaction Created ' . $reaction->reaction_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(Reaction $reaction)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $reaction->reaction_name,
            'id' => $reaction->id,
            'msg' => 'Reaction Updated ' . $reaction->reaction_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(Reaction $reaction)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $reaction->reaction_name,
            'id' => $reaction->id,
            'msg' => 'Reaction Deleted ' . $reaction->reaction_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(Reaction $reaction)
    {
    }
    
    public function forceDeleted(Reaction $reaction)
    {
    }
}

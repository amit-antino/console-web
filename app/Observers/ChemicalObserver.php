<?php

namespace App\Observers;

use App\Models\Product\Chemical;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ChemicalObserver
{
    public function created(Chemical $chemical)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $chemical->chemical_name,
            'id' => $chemical->id,
            'msg' => 'Product Created ' . $chemical->chemical_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(Chemical $chemical)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $chemical->chemical_name,
            'id' => $chemical->id,
            'msg' => 'Product Updated ' . $chemical->chemical_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(Chemical $chemical)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $chemical->chemical_name,
            'id' => $chemical->id,
            'msg' => 'Product Deleted ' . $chemical->chemical_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(Chemical $chemical)
    {
    }

    public function forceDeleted(Chemical $chemical)
    {
    }
}

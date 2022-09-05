<?php

namespace App\Observers;

use App\Models\ProductSystem\ProductSystem;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;


class ProductSystemObserver
{
    public function created(ProductSystem $productSystem)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productSystem->name,
            'id' => $productSystem->id,
            'msg' => 'Product System Created ' . $productSystem->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(ProductSystem $productSystem)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productSystem->name,
            'id' => $productSystem->id,
            'msg' => 'Product System Updated ' . $productSystem->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(ProductSystem $productSystem)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productSystem->name,
            'id' => $productSystem->id,
            'msg' => 'Product System deleted ' . $productSystem->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(ProductSystem $productSystem)
    {
    }
    
    public function forceDeleted(ProductSystem $productSystem)
    {
    }
}

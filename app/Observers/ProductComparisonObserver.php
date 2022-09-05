<?php

namespace App\Observers;

use App\Models\ProductSystem\ProductComparison;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ProductComparisonObserver
{
    public function created(ProductComparison $productComparison)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productComparison->comparison_name,
            'id' => $productComparison->id,
            'msg' => 'Product System Comparission Created ' . $productComparison->comparison_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ProductComparison $productComparison)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productComparison->comparison_name,
            'id' => $productComparison->id,
            'msg' => 'Product System Comparission Updated ' . $productComparison->comparison_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ProductComparison $productComparison)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $productComparison->comparison_name,
            'id' => $productComparison->id,
            'msg' => 'Product System Comparission Deleted ' . $productComparison->comparison_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ProductComparison $productComparison)
    {
    }

    public function forceDeleted(ProductComparison $productComparison)
    {
    }
}

<?php

namespace App\Observers;

use App\Models\Product\ChemicalProperties;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class ChemicalPropertiesObserver
{
    public function created(ChemicalProperties $chemicalProperties)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'product' => $chemicalProperties->chemical->chemical_name,
            'id' => $chemicalProperties->id,
            'msg' => 'Chemical Property Created for ' . $chemicalProperties->chemical->chemical_name . ' with Sub Property ' . $chemicalProperties->sub_property->sub_property_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(ChemicalProperties $chemicalProperties)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'product' => $chemicalProperties->chemical->chemical_name,
            'id' => $chemicalProperties->id,
            'msg' => 'Chemical Property Updated for ' . $chemicalProperties->chemical->chemical_name . ' with Sub Property ' . $chemicalProperties->sub_property->sub_property_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function deleted(ChemicalProperties $chemicalProperties)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'product' => $chemicalProperties->chemical->chemical_name,
            'id' => $chemicalProperties->id,
            'msg' => 'Chemical Property Deleted for ' . $chemicalProperties->chemical->chemical_name . ' with Sub Property ' . $chemicalProperties->sub_property->sub_property_name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function restored(ChemicalProperties $chemicalProperties)
    {
    }

    public function forceDeleted(ChemicalProperties $chemicalProperties)
    {
    }
}

<?php

namespace App\Observers;

use App\Models\Organization\Users\Department;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class DepartmentObserver
{
    public function created(Department $department)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $department->name,
            'id' => $department->id,
            'msg' => 'Department Created ' . $department->name
        ];
        $userSchema->notify(new UserNotification($data));
    }

    public function updated(Department $department)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $department->name,
            'id' => $department->id,
            'msg' => 'Department Updated ' . $department->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(Department $department)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $department->name,
            'id' => $department->id,
            'msg' => 'Department Deleted ' . $department->name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(Department $department)
    {
    }
    
    public function forceDeleted(Department $department)
    {
    }
}

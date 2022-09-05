<?php

namespace App\Observers;

use App\Models\Organization\Users\Employee;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $employee->user->first_name,
            'id' => $employee->id,
            'msg' => 'Employee Created  for User-' . $employee->user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function updated(Employee $employee)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $employee->user->first_name,
            'id' => $employee->id,
            'msg' => 'Employee Updated  for User-' . $employee->user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function deleted(Employee $employee)
    {
        $user_id = Auth::user()->id;
        $userSchema = User::find($user_id);
        $data = [
            'name' => $employee->user->first_name,
            'id' => $employee->id,
            'msg' => 'Employee Deleted  for User-' . $employee->user->first_name
        ];
        $userSchema->notify(new UserNotification($data));
    }
    
    public function restored(Employee $employee)
    {
    }
    
    public function forceDeleted(Employee $employee)
    {
    }
}

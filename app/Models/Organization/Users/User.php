<?php

namespace App\Models\Organization\Users;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Organization\Users\Designation;
use App\Models\Organization\Users\Department;
use Illuminate\Notifications\Notifiable;


class User extends Model
{
    use SoftDeletes;
    use Notifiable;
    use LogsActivity;
    protected static $logAttributes = ['first_name', 'last_name', 'email', 'mobile_number', 'status'];
    protected static $logName = 'User';

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function departments()
    {
        return $this->belongsToMany(Department::class, "employees", "user_id", "department_id")->withPivot('id');
    }

    public function designations()
    {
        return $this->belongsToMany(Designation::class, "employees", "user_id", "designation_id")->withPivot('id');
    }
}

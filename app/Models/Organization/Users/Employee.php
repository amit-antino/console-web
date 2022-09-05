<?php

namespace App\Models\Organization\Users;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Organization\Users\Designation;
use App\Models\Organization\Users\Department;
use App\Models\Organization\Users\User;

class Employee extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logAttributes = ['description', 'department_id', 'designation_id', 'status'];
    protected static $logName = 'Employee';
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'permission' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "employees", "id", "user_id")->withPivot('id');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, "employees", "id", "department_id");
    }
    public function designations()
    {
        return $this->belongsToMany(Designation::class, "employees", "id", "designation_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,  "user_id", "id");
    }
}

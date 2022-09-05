<?php

namespace App\Models\Organization\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Organization\Users\Designation;
use App\Models\Organization\Users\Department;
use App\Models\Organization\Users\User;

class UserPermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected static $logAttributes = ['description', 'department_id', 'designation_id', 'tenant_id', 'status'];
    protected static $logName = 'User Permission';
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
        return $this->belongsToMany(User::class, "user_permissions", "id", "user_id")->withPivot('id');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, "user_permissions", "id", "department_id");
    }
    public function designations()
    {
        return $this->belongsToMany(Designation::class, "user_permissions", "id", "designation_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,  "user_id", "id");
    }
    public function user_details()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function tenant_details()
    {
        return $this->hasOne('App\Models\Tenant\Tenant', 'id', 'tenant_id');
    }

    public static function list($fetch = 'array', $where = '', $keys = ['*'], $order = 'id-desc', $limit = '')
    {

        $table_course = self::select($keys)
            ->with([
                'user_details' => function ($q) {
                    $q->select('id', 'first_name', 'last_name', 'email', 'role');
                },
                'tenant_details' => function ($q) {
                    $q->select('id', 'organization_name');
                }
            ]);

        if ($where) {
            $table_course->whereRaw($where);
        }

        //$userlist['userCount'] = !empty($table_user->count())?$table_user->count():0;

        if (!empty($order)) {
            $order = explode('-', $order);
            $table_course->orderBy($order[0], $order[1]);
        }
        if ($fetch === 'array') {
            $list = $table_course->get();
            return json_decode(json_encode($list), true);
        } else if ($fetch === 'obj') {
            return $table_course->limit($limit)->get();
        } else if ($fetch === 'single') {
            return $table_course->get()->first();
        } else if ($fetch === 'count') {
            return $table_course->get()->count();
        } else {
            return $table_course->limit($limit)->get();
        }
    }
}

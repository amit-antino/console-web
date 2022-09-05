<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TenantUser extends Model
{
    use  LogsActivity;
    // protected $table= "tenant_users";
    protected $dates = ['created_at', 'updated_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logName = 'Tenants User';
    protected static $logOnlyDirty = true;

    public function user_details()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function tenant_details()
    {
        return $this->hasOne('App\Models\Tenant\Tenant', 'id', 'tenant_id');
    }

    public function tenant_config()
    {
        return $this->hasOne('App\Models\Tenant\TenantConfig', 'id', 'tenant_id');
    }

    public static function list($fetch = 'array', $where = '', $keys = ['*'], $order = 'id-desc', $limit = '')
    {
        
        $table_course = self::select($keys)
            ->with([
                'user_details' => function ($q) {
                    $q->select('id', 'first_name', 'last_name', 'email', 'role','status')->where('status','active');
                },
                'tenant_details' => function ($q) {
                    $q->select('id', 'name');
                },
                'tenant_config' => function ($q) {
                    $q->select(['*']);
                }
            ]);

        if ($where) {
            $table_course->whereRaw($where);
        }
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

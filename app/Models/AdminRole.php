<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use SoftDeletes;
    protected $casts = [
        'tenant_id' => 'array',
        'roles' => 'array',
    ];

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

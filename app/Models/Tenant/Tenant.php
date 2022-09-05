<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Tenant extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['name'];
    protected  $casts =
    [
        'account_details' => 'array',
        'billing_information' => 'array',
        'guide_document' => 'array',
        'images' => 'array',
    ];
    protected static $logName = 'Tenants';
    protected static $logOnlyDirty = true;

    public function organization_type_details()
    {
        return $this->hasOne('App\Models\Master\TenantMasterType', 'id', 'type');
    }
    public function plan_details()
    {
        return $this->hasOne('App\Models\Master\TenantMasterPlan', 'id', 'plan_type');
    }
    public function location()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
    public function tenant_config()
    {
        return $this->hasOne('App\Models\Tenant\TenantConfig', 'tenant_id', 'id');
    }
}

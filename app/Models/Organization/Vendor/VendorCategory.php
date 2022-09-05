<?php

namespace App\Models\Organization\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class VendorCategory extends Model
{
    use SoftDeletes, LogsActivity;
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}

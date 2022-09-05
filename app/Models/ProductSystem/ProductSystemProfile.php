<?php

namespace App\Models\ProductSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductSystemProfile extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logName = 'Product System Profile';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'product_input' => 'array',
        'product_output' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}

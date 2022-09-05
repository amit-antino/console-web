<?php

namespace App\Models\ProductSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductComparison extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['comparison_name', 'description', 'product_system', 'status'];
    protected static $logName = 'Product System Comparisons';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'product_system' => 'array',
        'tags' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}

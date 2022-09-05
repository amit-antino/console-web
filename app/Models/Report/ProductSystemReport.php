<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;
use App\Models\ProductSystem\ProductSystem;;

class ProductSystemReport extends Model
{
    use SoftDeletes, LogsActivity;
    use Notifiable;
    protected static $logAttributes = [
        'report_name',
        'report_type',
        'product_system_id',
        'process_simulation_ids',
        'status',
    ];

    protected static $logName = 'Product SystemReport';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $casts = [

        'tags' => 'array',
        'process_simulation_ids' => 'array'

    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function productSystem()
    {
        return $this->belongsTo(ProductSystem::class, "product_system_id", "id");
    }
}

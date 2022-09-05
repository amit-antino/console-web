<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ToleranceReport extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;

    protected static $logAttributes = [
        'name',
        'output_data',
        'status'
    ];
    protected static $logName = 'Tolerance Report';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This Tolerance Report has been {$eventName}";
    }
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'output_data' => 'array'
    ];

}

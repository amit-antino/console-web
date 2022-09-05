<?php

namespace App\Models\DataRequest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class DataRequest extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'data_request' => 'array'
    ];
    protected $softDelete = true;
    public $timestamps = true; 
}

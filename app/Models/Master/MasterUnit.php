<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MasterUnit extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['unit_name','unit_constant','default_unit','description', 'status'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'unit_constant' => 'array',
    ];
}

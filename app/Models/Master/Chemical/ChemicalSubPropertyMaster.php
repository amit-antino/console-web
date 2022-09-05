<?php

namespace App\Models\Master\Chemical;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ChemicalSubPropertyMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'fields' => 'array',
        'dynamic_fields' => 'array',
    ];
    public function main_prop()
    {
        return $this->hasOne('App\Models\Master\Chemical\ChemicalPropertyMaster', 'id', 'property_id');
    }
}

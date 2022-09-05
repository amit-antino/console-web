<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;
use App\Models\Product\Chemical;

class ChemicalProperties extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['chemical_id', 'sub_property_id', 'prop_json', 'property_id', 'dynamic_prop_json', 'status'];
    protected static $logName = 'Chemical Properties';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    protected $casts = [
        'prop_json' => 'array',
        'dynamic_prop_json' => 'array',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function sub_property_prop()
    {
        return $this->hasOne('App\Models\Master\Chemical\ChemicalSubPropertyMaster', 'id', 'sub_property_id');
    }
    public function sub_property()
    {
        return $this->belongsTo(ChemicalSubPropertyMaster::class, 'sub_property_id', 'id');
    }
    public function chemical()
    {
        return $this->belongsTo(Chemical::class, 'product_id', 'id');
    }
}

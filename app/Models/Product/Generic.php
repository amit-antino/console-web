<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\Chemical\ChemicalCategory;
use App\Models\Master\Chemical\ChemicalClassification;

class Generic extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name', 'category_id', 'classification_id', 'product_brand_name', 'own_product', 'vendor_list', 'other_name', 'notes', 'status'];
    protected static $logName = 'Generic';
    protected static $logOnlyDirty = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'vendor_list' => 'array',
        'other_name' => 'array',
        'tags' => 'array',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function chemicalCategory()
    {
        return $this->belongsTo(ChemicalCategory::class, "category_id", "id");
    }

    public function chemicalClassification()
    {
        return $this->belongsTo(ChemicalClassification::class, "classification_id", "id");
    }
}

<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\Chemical\ChemicalCategory;
use App\Models\Master\Chemical\ChemicalClassification;

class Chemical extends Model
{
    
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['chemical_name','product_type_id','tenant_id','molecular_formula', 'category_id', 'classification_id', 'smiles', 'product_brand_name', 'own_product', 'ec_number', 'vendor_list', 'other_name', 'inchi_key', 'inchi', 'iupac', 'cas_no', 'notes', 'status'];
    protected static $logName = 'Chemicals';
    protected static $logOnlyDirty = true;
    protected $fillable = ['chemical_name','product_type_id','tenant_id','molecular_formula', 'category_id', 'classification_id', 'smiles', 'product_brand_name', 'own_product', 'ec_number', 'vendor_list', 'other_name', 'inchi_key', 'inchi', 'iupac', 'cas_no', 'notes', 'status'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'vendor_list' => 'array',
        'smiles' => 'array',
        'cas_no' => 'array',
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

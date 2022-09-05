<?php

namespace App\Models\Master\Chemical\Hazard;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Chemical\Hazard\HazardClass;
use App\Models\Master\Chemical\Hazard\HazardCategory;
use App\Models\Master\Chemical\Hazard\HazardPictogram;
use App\Models\Master\Chemical\Hazard\CodeStatement;

class Hazard extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'hazard_class_id' => 'array',
        'category_id' => 'array',
        'code_statement_id' => 'array',
    ];
    public function hazard_class_details()
    {
        return $this->hasOne(HazardClass::class, 'id', 'hazard_class_id');
    }
    public function hazard_category_details()
    {
        return $this->hasOne(HazardCategory::class, 'id', 'category_id');
    }
    public function hazard_pictogram_details()
    {
        return $this->hasOne(HazardPictogram::class, 'id', 'pictogram_id');
    }
    public function code_statement_details()
    {
        return $this->belongsToJson(CodeStatement::class, 'id', 'code_statement_id[]');
    }
}

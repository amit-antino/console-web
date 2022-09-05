<?php

namespace App\Models\Master\Chemical;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;
class ChemicalPropertyMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
   
    public function sub_property_data()
    {
        return $this->hasmany('App\Models\Master\Chemical\ChemicalSubPropertyMaster', 'property_id', 'id');
    }
}

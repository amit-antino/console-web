<?php

namespace App\Models\Master\EnergyUtilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EnergyPropertyMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['property_name'];
    protected static $logName = 'Energy Property Master';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    public function energy_sub_property_data()
    {
        return $this->hasmany('App\Models\Master\EnergyUtilities\EnergySubPropertyMaster', 'property_id', 'id');
    }
}

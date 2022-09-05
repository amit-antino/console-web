<?php

namespace App\Models\Experiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Experiment\sim_inp_template_upload;

class SimulateInputExcelTemplate extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true; 
    public function forwardlog()
    {
        return $this->hasMany(sim_inp_template_upload::class, 'template_id', 'id')->where('type', 'forward');
    }
    public function reverselog()
    {
        return $this->hasMany(sim_inp_template_upload::class, 'template_id', 'id')->where('type', 'reverse');
    }
}

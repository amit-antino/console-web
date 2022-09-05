<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProcessExperiment\ProcessExperiment;

class ProcessExpEnergyFlow extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function getExp()
    {
        return $this->belongsTo(ProcessExperiment::class, "process_id", "id");
    }
}

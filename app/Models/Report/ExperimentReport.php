<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessExperiment\ProcessExperiment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Organization\Users\User;
use App\Models\ProcessExperiment\SimulateDataset;
use App\Models\ProcessExperiment\Variation;
use App\Models\ProcessExperiment\SimulateInput;

class ExperimentReport extends Model
{
    use SoftDeletes, LogsActivity;

    protected static $logAttributes = [
        'name',
        'report_type',
        'output_data',
        'status'
    ];
    protected static $logName = 'Experiment Report';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This Experiment Report has been {$eventName}";
    }
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'output_data' => 'array'
    ];


    public function get_experiment()
    {
        return $this->belongsTo(ProcessExperiment::class, "experiment_id", "id");
    }

    public function get_ignoredeleteexperiment()
    {
        return $this->belongsTo(ProcessExperiment::class, "experiment_id", "id")->withTrashed();
    }

    public function getCreatedBy()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function getUpdatedBy()
    {
        return $this->belongsTo(User::class, "updated_by", "id");
    }
    public function getdataset()
    {
        return $this->belongsTo(SimulateInput::class, "simulation_input_id", "id");
    }
    public function getconfig()
    {
        return $this->belongsTo(Variation::class, "variation_id", "id");
    }
    public function getdataset_ignoredelete()
    {
        return $this->belongsTo(SimulateInput::class, "simulation_input_id", "id")->withTrashed();
    }
}

<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\Organization\Experiment\ExperimentCategory;
use App\Models\Organization\Experiment\ExperimentClassification;
use App\Models\Tenant\Project;

class ProcessExperiment extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['process_experiment_name', 'category_id', 'description', 'chemical', 'data_source', 'classification_id', 'experiment_unit', 'main_product_output', 'main_product_input', 'status'];
    protected static $logName = 'Experiments';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'classification_id' => 'array',
        'chemical' => 'array',
        'main_product_input' => 'array',
        'main_product_output' => 'array',
        'experiment_unit' => 'array',
        'energy_id' => 'array',
        'tags' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }

    public function experiment_category()
    {
        return $this->belongsTo(ExperimentCategory::class, "category_id", "id");
    }

    public function experiment_classification()
    {
        return $this->belongsTo(ExperimentClassification::class);
    }

    public function experiment_unit()
    {
        return $this->hasMany('\App\Models\ProcessExperiment\ExperimentUnit');
    }
    public function get_project()
    {
        return $this->belongsTo(Project::class, "project_id", "id");
    }
}

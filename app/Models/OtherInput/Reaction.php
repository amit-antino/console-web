<?php

namespace App\Models\OtherInput;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Reaction extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['reaction_name', 'reaction_source', 'reaction_type', 'description', 'chemical_reaction_left', 'chemical_reaction_right', 'status'];
    protected static $logName = 'Reaction';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'chemical_reaction_left' => 'array',
        'chemical_reaction_right' => 'array',
        'reaction_reactant' => 'array',
        'reaction_product' => 'array',
        'tags' => 'array',
        'reactant_component'=>'array',
        'product_component'=>'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}

<?php

namespace App\Models\Organization\Lists;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Organization\Lists\ClassificationList;
use App\Models\Organization\Lists\CategoryList;

class RegulatoryList extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['list_name', 'classification_id', 'color_code', 'region', 'country_id', 'state_id', 'compilation', 'no_of_list', 'source_url', 'source_name', 'list_category', 'status', 'hover_msg','hazard_code','match_type','compilation','display_hazard_code'];
    protected static $logName = 'Lists';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'access' => 'array',
        'tags' => 'array',
        'field_of_display' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function classificationList()
    {
        return $this->belongsTo(ClassificationList::class, 'classification_id', 'id');
    }

    public function categoryList()
    {
        return $this->belongsTo(CategoryList::class, 'category_id', 'id');
    }

    public function chemicalLists()
    {
        return $this->hasMany('\App\Models\ListProduct', 'list_id', 'id');
    }
}

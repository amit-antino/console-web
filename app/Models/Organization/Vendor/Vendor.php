<?php

namespace App\Models\Organization\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Organization\Vendor\VendorClassification;
use App\Models\Organization\Vendor\VendorCategory;
use App\Models\Country;

class Vendor extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name'];
    protected static $logName = 'Vendor';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'tags' => 'array',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function classification()
    {
        return $this->belongsTo(VendorClassification::class, "classificaton_id", "id");
    }
    public function category()
    {
        return $this->belongsTo(VendorCategory::class, "category_id", "id");
    }
    public function location()
    {
        return $this->belongsTo(Country::class, "country_id", "id");
    }
}

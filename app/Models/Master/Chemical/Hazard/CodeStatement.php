<?php

namespace App\Models\Master\Chemical\Hazard;

use Illuminate\Database\Eloquent\Model;

class CodeStatement extends Model
{
    protected $fillable = ['title', 'code', 'description', 'type', 'sub_code_type_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
}

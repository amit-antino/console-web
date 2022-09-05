<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Chemical\Hazard\Hazard;

class ListProduct extends Model
{
    protected $fillable = ['list_id', 'chemical_name','other_name', 'molecular_formula', 'cas', 'inchi_key', 'smiles', 'list_name', 'source', 'organization', 'external_link', 'ec_number', 'groups', 'hazard_class', 'hazard_code', 'usage_app_category', 'technical_fun', 'possible_usage', 'monitoring_data', 'rsl_limits_table', 'product_line_restriction', 'specific_restriction', 'numeric_limit', 'test_methods', 'substi_option', 'notes','date_of_inclusion','hazard_statement','hazard_category','eu_hazard_statement,','iupac'];
    protected $casts = [
        'cas' => 'array',
    ];
    public function hazard_pictogram_details()
    {
        return $this->hasOne(Hazard::class, 'hazard_code', 'hazard_code');
    }
}
        
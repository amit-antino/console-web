<?php

namespace App\Imports;

use App\Models\ListProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ListProductImport implements ToCollection
{
    public function  __construct($list_id)
    {
        //dd($data);
        $this->list_id = $list_id;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key != 0)  {
                ListProduct::create([
                    'list_id'     => $this->list_id,
                    'chemical_name'     => $row[0],
                    'other_name'     => $row[1],
                    'molecular_formula'    => $row[2],
                    'ec_number' => $row[3],
                    'cas' => explode(',', $row[4]),
                    'iupac' => $row[5],
                    'inchi_key' => $row[6],
                    'smiles' => $row[7],
                    // 'list_name' => $row[6],
                    // 'source' => $row[7],
                    // 'organization' => $row[8],
                    // 'hazard_class' => $row[10], ///CLASS
                    // 'product_line_restriction' => $row[12], ///CLASS
                    // 'specific_restriction' => $row[13], ///SPECIFIC RESTRICTION
                    // 'numeric_limit' => $row[14], ///NUMERIC LIMIT
                    // 'test_methods' => $row[15], ///TEST METHOD
                    'notes' => $row[8], ///NOTES
                    'date_of_inclusion' => $row[9],
                    'hazard_code' => $row[10],
                    'hazard_statement' => $row[11],
                    'hazard_class' => $row[12],
                    'hazard_category' => $row[13],
                    'eu_hazard_statement' => $row[14],
                    'rsl_limits_table' => $row[15], ///CLASS
                ]);
            }
        }
    }
}

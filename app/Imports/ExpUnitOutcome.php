<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\Master\MasterUnit;

class ExpUnitOutcome implements ToCollection
{
    public function  __construct($tenant_id)
    {
        $this->tenant_id = $tenant_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key != 0) {
                $master_unit = MasterUnit::where('unit_name', $value[1])->first();
                $unit_type = isset($master_unit->id) ? $master_unit->id : 0;
                //$unit_type =0;
              //  dd($value);
                if (!empty($value[0])) {
                    $insert_data = array(
                        'name'  => $value[0],
                        'tenant_id'   => $this->tenant_id,
                        'unittype'   => $unit_type,
                        'description'   => !empty($value[2]) ? $value[2] : '',
                        'status' => 'active',
                    );
                    ExperimentOutcomeMaster::create($insert_data);
                }
            }
        }
    }
}

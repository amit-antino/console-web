<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Master\MasterUnit;

class ExpCondition implements ToCollection
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
                    $insert_data = array(
                        'name'  => $value[0],
                        'tenant_id'   => $this->tenant_id,
                        'unittype'   => $unit_type,
                        'description'   => $value[2],
                        'status' => 'active',
                    );
                
                    ExperimentConditionMaster::create($insert_data);
            }
        }
    }

}

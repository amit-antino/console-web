<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\Organization\Experiment\EquipmentUnit;

class ExpUnit implements ToCollection
{
    public function  __construct($tenant_id)
    {
        $this->tenant_id = $tenant_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key != 0) {
                $unit=0;
                $equip_unit = EquipmentUnit::where('equipment_name', $value[1])->first();
                $unit = isset($equip_unit->id) ? $equip_unit->id : 0;
                if ($value[3] != "") {
                    $tags = explode(",", $value[2]);
                } else {
                    $tags = [];
                }
                    $insert_data = array(
                        'experiment_unit_name'  => $value[0],
                        'tenant_id'   => session()->get('tenant_id'),
                        'equipment_unit_id'   => $unit,
                        'description'   => $value[1],
                        'tags'=>$tags,
                        'status' => $value[3],
                    );
                
                    ExperimentUnit::create($insert_data);
            }
        }
    }

}

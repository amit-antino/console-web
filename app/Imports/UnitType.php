<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Master\MasterUnit;

class UnitType implements ToCollection
{
    public function  __construct($tenant_id)
    {
        $this->tenant_id = $tenant_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key != 0) {
                //$master_unit = MasterUnit::where('unit_name', $value[1])->first();
                //$unit_type = isset($master_unit->id) ? $master_unit->id : 0;
                $unit_constant=[];
                if (!empty($value[1])) {
                    $uc_data = explode(";",$value[1]);
                    foreach ($uc_data as $subkey => $const) {
                        $const_det = explode(":",$const);
                        $default_unit = 0;
                        if (!empty($const)) {
                            $unit_constant[$subkey]['id'] = json_encode($subkey);
                            $unit_constant[$subkey]['unit_name'] = $const_det[0];
                            $unit_constant[$subkey]['unit_symbol'] = $const_det[1];
                            if($const_det[0]==$value[2]){
                                $default_unit = $subkey;
                            }
                        }
                    }
                    
                }
                    $insert_data = array(
                        'unit_name'  => $value[0],
                        'unit_constant'   => $unit_constant,
                        'default_unit'   => $default_unit,
                        'description'   => $value[3],
                        'status' => 'active',
                    );
                
                    MasterUnit::create($insert_data);
            }
        }
    }

}

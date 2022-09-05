<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SimulationTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('simulation_types')->delete();
        
        \DB::table('simulation_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'simulation_name' => 'Early 1',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}]',
                'enery_utilities' => '[]',
                'description' => 'This is simulation type Early 1 ',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'simulation_name' => 'Early 2',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}]',
                'enery_utilities' => '[]',
                'description' => 'This is simulation type Early 2',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'simulation_name' => 'Early 3',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}, {"id": 3, "data_source": "Process Detailed"}]',
                'enery_utilities' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Utility-Process Level"}, {"id": 3, "data_source": "Utility-Detailed Level"}]',
                'description' => 'This is simulation type Early 3',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'simulation_name' => 'Process First',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}, {"id": 3, "data_source": "Process Detailed"}]',
                'enery_utilities' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Utility-Process Level"}, {"id": 3, "data_source": "Utility-Detailed Level"}]',
                'description' => 'This is simulation type Process First',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'simulation_name' => 'Process Sim',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}, {"id": 3, "data_source": "Process Detailed"}]',
                'enery_utilities' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Utility-Process Level"}, {"id": 3, "data_source": "Utility-Detailed Level"}]',
                'description' => 'This is simulation type Process Sim',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 0,
                'simulation_name' => 'Plant Data',
                'mass_balance' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Process Chemistry"}, {"id": 3, "data_source": "Process Detailed"}]',
                'enery_utilities' => '[{"id": 1, "data_source": "Basic User Input"}, {"id": 2, "data_source": "Utility-Process Level"}, {"id": 3, "data_source": "Utility-Detailed Level"}]',
                'description' => 'This is simulation type Plan Data',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
        ));
        
        
    }
}
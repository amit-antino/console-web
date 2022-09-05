<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReactionPhasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reaction_phases')->delete();
        
        \DB::table('reaction_phases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 21,
                'name' => 'vghvbhg',
                'notation' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-28 10:55:27',
                'updated_at' => '2022-04-28 10:55:27',
            ),
        ));
        
        
    }
}
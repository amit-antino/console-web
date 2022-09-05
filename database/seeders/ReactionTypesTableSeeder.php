<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReactionTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reaction_types')->delete();
        
        \DB::table('reaction_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Irreversible',
                'description' => 'Irreversible',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-02 22:20:51',
                'updated_at' => '2021-03-02 22:35:51',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'name' => 'Reversible',
                'description' => 'Reversible',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-02 22:36:07',
                'updated_at' => '2021-03-02 22:36:07',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 21,
                'name' => 'test',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 23:20:19',
                'updated_at' => '2022-04-14 23:22:09',
            ),
        ));
        
        
    }
}
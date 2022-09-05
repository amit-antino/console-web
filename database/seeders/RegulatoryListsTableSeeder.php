<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegulatoryListsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('regulatory_lists')->delete();
        
        
        
    }
}
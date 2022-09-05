<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatasetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('datasets')->delete();
        
        
        
    }
}
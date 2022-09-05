<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_types')->delete();
        
        
        
    }
}
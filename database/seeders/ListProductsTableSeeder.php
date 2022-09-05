<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_products')->delete();
        
        
        
    }
}
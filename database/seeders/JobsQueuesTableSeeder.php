<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobsQueuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jobs_queues')->delete();
        
        
        
    }
}
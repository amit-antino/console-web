<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SimInpTemplateUploadsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sim_inp_template_uploads')->delete();
        
        \DB::table('sim_inp_template_uploads')->insert(array (
            0 => 
            array (
                'id' => 2,
                'template_id' => '20',
                'template_name' => 'testfwd',
                'variation_id' => '25',
                'type' => 'forward',
                'excel_file' => 'testfwd#1YQdJ2dOGp#forward.xlsx',
                'status' => 1,
                'entry_by' => '1',
                'ip_add' => '127.0.0.1',
                'created_at' => '2022-04-26 05:07:43',
                'updated_at' => '2022-04-26 17:09:58',
            ),
            1 => 
            array (
                'id' => 3,
                'template_id' => '21',
                'template_name' => 'reverserrangetest',
                'variation_id' => '25',
                'type' => 'reverse',
                'excel_file' => 'reverserrangetest#4y1aKReQGw#reverse.xlsx',
                'status' => 1,
                'entry_by' => '1',
                'ip_add' => '127.0.0.1',
                'created_at' => '2022-04-27 10:14:42',
                'updated_at' => '2022-04-27 10:15:28',
            ),
            2 => 
            array (
                'id' => 4,
                'template_id' => '21',
                'template_name' => 'reverserrangetest',
                'variation_id' => '25',
                'type' => 'reverse',
                'excel_file' => 'reverserrangetest#4y1aKReQGw#reverse1.xlsx',
                'status' => 1,
                'entry_by' => '1',
                'ip_add' => '127.0.0.1',
                'created_at' => '2022-04-27 10:41:28',
                'updated_at' => '2022-04-27 10:41:33',
            ),
            3 => 
            array (
                'id' => 5,
                'template_id' => '21',
                'template_name' => 'reverserrangetest',
                'variation_id' => '25',
                'type' => 'reverse',
                'excel_file' => 'reverserrangetest#4y1aKReQGw#reverse2.xlsx',
                'status' => 1,
                'entry_by' => '1',
                'ip_add' => '127.0.0.1',
                'created_at' => '2022-04-28 05:21:52',
                'updated_at' => '2022-04-28 17:22:17',
            ),
            4 => 
            array (
                'id' => 6,
                'template_id' => '21',
                'template_name' => 'reverserrangetest',
                'variation_id' => '25',
                'type' => 'reverse',
                'excel_file' => 'reverserrangetest#4y1aKReQGw#reverse3.xlsx',
                'status' => 1,
                'entry_by' => '1',
                'ip_add' => '127.0.0.1',
                'created_at' => '2022-04-28 05:25:16',
                'updated_at' => '2022-04-28 17:25:25',
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessExpProfileMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_exp_profile_masters')->delete();
        
        \DB::table('process_exp_profile_masters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'process_exp_id' => 1,
                'condition' => '[141, 142, 148]',
                'outcome' => '[358, 359, 361]',
                'reaction' => '[]',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 04:09:00',
                'updated_at' => '2022-02-01 04:09:00',
            ),
            1 => 
            array (
                'id' => 2,
                'process_exp_id' => 3,
                'condition' => '[481, 523, 524]',
                'outcome' => '[143, 651, 663, 664]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-28 22:21:20',
                'updated_at' => '2022-03-10 23:22:53',
            ),
            2 => 
            array (
                'id' => 3,
                'process_exp_id' => 7,
                'condition' => '[519]',
                'outcome' => '[658]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-04 02:26:46',
                'updated_at' => '2022-03-04 02:26:47',
            ),
            3 => 
            array (
                'id' => 4,
                'process_exp_id' => 11,
                'condition' => '[519]',
                'outcome' => '[658, 659]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 04:37:02',
                'updated_at' => '2022-03-08 04:40:39',
            ),
            4 => 
            array (
                'id' => 5,
                'process_exp_id' => 15,
                'condition' => '[481]',
                'outcome' => '[143]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-09 23:06:28',
                'updated_at' => '2022-03-09 23:06:28',
            ),
            5 => 
            array (
                'id' => 6,
                'process_exp_id' => 18,
                'condition' => '[141]',
                'outcome' => '[357]',
                'reaction' => '[]',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:58:05',
                'updated_at' => '2022-03-11 20:58:05',
            ),
            6 => 
            array (
                'id' => 7,
                'process_exp_id' => 19,
                'condition' => '[525]',
                'outcome' => '[665]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 22:24:33',
                'updated_at' => '2022-03-11 22:24:33',
            ),
            7 => 
            array (
                'id' => 8,
                'process_exp_id' => 21,
                'condition' => '[481, 523]',
                'outcome' => '[143]',
                'reaction' => '[]',
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 08:28:02',
                'updated_at' => '2022-03-15 08:28:02',
            ),
            8 => 
            array (
                'id' => 9,
                'process_exp_id' => 23,
                'condition' => '[526, 527]',
                'outcome' => '[674, 675]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 22:05:36',
                'updated_at' => '2022-04-14 22:05:36',
            ),
            9 => 
            array (
                'id' => 10,
                'process_exp_id' => 24,
                'condition' => '[527]',
                'outcome' => '[673]',
                'reaction' => '[]',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 18:28:42',
                'updated_at' => '2022-04-15 18:28:42',
            ),
            10 => 
            array (
                'id' => 11,
                'process_exp_id' => 26,
                'condition' => '[527]',
                'outcome' => '[673]',
                'reaction' => '[]',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 11:42:44',
                'updated_at' => '2022-04-27 11:42:44',
            ),
        ));
        
        
    }
}
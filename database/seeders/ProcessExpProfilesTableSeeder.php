<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessExpProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_exp_profiles')->delete();
        
        \DB::table('process_exp_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'process_exp_id' => 3,
                'variation_id' => 4,
                'experiment_unit' => 1,
                'condition' => '[481]',
                'outcome' => '[143]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-28 21:39:29',
                'updated_at' => '2022-02-28 22:24:20',
            ),
            1 => 
            array (
                'id' => 2,
                'process_exp_id' => 4,
                'variation_id' => 5,
                'experiment_unit' => 1,
                'condition' => '[519]',
                'outcome' => '[658]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 05:12:35',
                'updated_at' => '2022-03-03 05:12:35',
            ),
            2 => 
            array (
                'id' => 3,
                'process_exp_id' => 7,
                'variation_id' => 8,
                'experiment_unit' => 1,
                'condition' => '[519]',
                'outcome' => '[658]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-04 02:24:41',
                'updated_at' => '2022-03-04 02:24:49',
            ),
            3 => 
            array (
                'id' => 4,
                'process_exp_id' => 18,
                'variation_id' => 16,
                'experiment_unit' => 1,
                'condition' => '[142, 148]',
                'outcome' => '[357, 359]',
                'reaction' => '[]',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:58:18',
                'updated_at' => '2022-03-11 20:58:18',
            ),
            4 => 
            array (
                'id' => 5,
                'process_exp_id' => 21,
                'variation_id' => 23,
                'experiment_unit' => 1,
                'condition' => '[523, 524]',
                'outcome' => '[663]',
                'reaction' => '[]',
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 08:28:11',
                'updated_at' => '2022-03-15 08:28:11',
            ),
            5 => 
            array (
                'id' => 6,
                'process_exp_id' => 21,
                'variation_id' => 23,
                'experiment_unit' => 2,
                'condition' => '[523, 524, 525]',
                'outcome' => '[665]',
                'reaction' => '[]',
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 08:28:20',
                'updated_at' => '2022-03-15 08:28:20',
            ),
            6 => 
            array (
                'id' => 7,
                'process_exp_id' => 1,
                'variation_id' => 2,
                'experiment_unit' => 1,
                'condition' => '[155]',
                'outcome' => '[357]',
                'reaction' => '[]',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_at' => NULL,
                'created_at' => '2022-03-22 02:18:43',
                'updated_at' => '2022-03-22 02:18:43',
            ),
            7 => 
            array (
                'id' => 8,
                'process_exp_id' => 23,
                'variation_id' => 25,
                'experiment_unit' => 1,
                'condition' => '[527]',
                'outcome' => '[675]',
                'reaction' => '[]',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 22:05:27',
                'updated_at' => '2022-04-14 22:05:46',
            ),
            8 => 
            array (
                'id' => 9,
                'process_exp_id' => 24,
                'variation_id' => 26,
                'experiment_unit' => 1,
                'condition' => '[528]',
                'outcome' => '[675]',
                'reaction' => '[]',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 18:28:54',
                'updated_at' => '2022-04-15 18:28:54',
            ),
            9 => 
            array (
                'id' => 10,
                'process_exp_id' => 26,
                'variation_id' => 27,
                'experiment_unit' => 1,
                'condition' => '[528]',
                'outcome' => '[674]',
                'reaction' => '[]',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 11:42:51',
                'updated_at' => '2022-04-27 11:42:51',
            ),
        ));
        
        
    }
}
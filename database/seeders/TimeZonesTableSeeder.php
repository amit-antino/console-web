<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TimeZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('time_zones')->delete();
        
        \DB::table('time_zones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'GMT',
                'description' => 'Greenwich Mean Time',
                'time_zone' => 'GMT',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'UTC',
                'description' => 'Universal Coordinated Time	',
                'time_zone' => 'GMT',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'ECT	',
                'description' => 'European Central Time	',
                'time_zone' => 'GMT+1:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'EET	',
                'description' => 'Eastern European Time',
                'time_zone' => 'GMT+2:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'ART	',
            'description' => '(Arabic) Egypt Standard Time	',
                'time_zone' => 'GMT+2:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'EAT',
                'description' => 'Eastern African Time	',
                'time_zone' => 'GMT+3:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'MET',
                'description' => 'Middle East Time	',
                'time_zone' => 'GMT+3:30',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'NET	',
                'description' => 'Near East Time	',
                'time_zone' => 'GMT+4:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'PLT',
                'description' => 'Pakistan Lahore Time	',
                'time_zone' => 'GMT+5:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'IST',
                'description' => 'India Standard Time	',
                'time_zone' => 'GMT+5:30',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'BST',
                'description' => 'Bangladesh Standard Time	',
                'time_zone' => 'GMT+6:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'VST',
                'description' => 'Vietnam Standard Time	',
                'time_zone' => 'GMT+7:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'CTT',
                'description' => 'China Taiwan Time	',
                'time_zone' => 'GMT+8:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'JST	',
                'description' => 'Japan Standard Time	',
                'time_zone' => 'GMT+9:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'ACT	',
                'description' => 'Australia Central Time	',
                'time_zone' => 'GMT+9:30',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'AET',
                'description' => 'Australia Eastern Time	',
                'time_zone' => 'GMT+10:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'SST',
                'description' => 'Solomon Standard Time	',
                'time_zone' => 'GMT+11:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'NST	',
                'description' => 'New Zealand Standard Time',
                'time_zone' => 'GMT+12:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'MIT	',
                'description' => 'Midway Islands Time	',
                'time_zone' => 'GMT-11:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'HST',
                'description' => 'Hawaii Standard Time	',
                'time_zone' => 'GMT-10:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'AST',
                'description' => 'Alaska Standard Time	',
                'time_zone' => 'GMT-9:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'PST	',
                'description' => 'Pacific Standard Time	',
                'time_zone' => 'GMT-8:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'PNT',
                'description' => 'Phoenix Standard Time	',
                'time_zone' => 'GMT-7:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'MST',
                'description' => 'Mountain Standard Time	',
                'time_zone' => 'GMT-7:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'CST',
                'description' => 'Central Standard Time	',
                'time_zone' => 'GMT-6:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'EST',
                'description' => 'Eastern Standard Time	',
                'time_zone' => 'GMT-5:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'IET',
                'description' => 'Indiana Eastern Standard Time	',
                'time_zone' => 'GMT-5:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'PRT',
                'description' => 'Puerto Rico and US Virgin Islands Time	',
                'time_zone' => 'GMT-4:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'CNT	',
                'description' => 'Canada Newfoundland Time	',
                'time_zone' => 'GMT-3:30',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'AGT',
                'description' => 'Argentina Standard Time	',
                'time_zone' => 'GMT-3:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'BET',
                'description' => 'Brazil Eastern Time	',
                'time_zone' => 'GMT-3:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'CAT',
                'description' => 'Central African Time	',
                'time_zone' => 'GMT-1:00',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
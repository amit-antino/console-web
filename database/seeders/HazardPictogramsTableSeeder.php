<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HazardPictogramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hazard_pictograms')->delete();
        
        \DB::table('hazard_pictograms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS01.gif',
                'title' => 'Exploding Bomb',
                'code' => 'GHS01',
                'description' => 'Explosives',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:45:20',
                'updated_at' => '2020-10-15 02:45:20',
            ),
            1 => 
            array (
                'id' => 2,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS02.gif',
                'title' => 'Flame',
                'code' => 'GHS02',
                'description' => 'Flammables',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:48:00',
                'updated_at' => '2020-10-15 02:48:00',
            ),
            2 => 
            array (
                'id' => 3,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS05.gif',
                'title' => 'Corrosion',
                'code' => 'GHS05',
                'description' => 'Corrosives',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:48:46',
                'updated_at' => '2020-10-15 02:48:46',
            ),
            3 => 
            array (
                'id' => 4,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS03.gif',
                'title' => 'Flame Over Circle',
                'code' => 'GHS03',
                'description' => 'Oxidizers',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:49:17',
                'updated_at' => '2020-10-15 02:49:17',
            ),
            4 => 
            array (
                'id' => 5,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS04.gif',
                'title' => 'Gas Cylinder',
                'code' => 'GHS04',
                'description' => 'Compressed Gases',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:49:50',
                'updated_at' => '2020-10-15 02:49:50',
            ),
            5 => 
            array (
                'id' => 6,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS06.gif',
                'title' => 'Skull and Crossbones',
                'code' => 'GHS06',
                'description' => 'Acute Toxicity',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:50:34',
                'updated_at' => '2020-10-15 02:50:34',
            ),
            6 => 
            array (
                'id' => 7,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS07.gif',
                'title' => 'Exclamation Mark',
                'code' => 'GHS07',
                'description' => 'Irritant',
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:51:02',
                'updated_at' => '2020-10-15 02:51:02',
            ),
            7 => 
            array (
                'id' => 8,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS08.gif',
                'title' => 'Health Hazard',
                'code' => 'GHS08',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:51:27',
                'updated_at' => '2020-10-15 02:51:27',
            ),
            8 => 
            array (
                'id' => 9,
                'hazard_pictogram' => 'assets/hazard_pictogram/GHS09.gif',
                'title' => 'Environment',
                'code' => 'GHS09',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:51:53',
                'updated_at' => '2020-10-15 02:51:53',
            ),
        ));
        
        
    }
}
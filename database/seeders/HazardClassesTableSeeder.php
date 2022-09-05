<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HazardClassesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hazard_classes')->delete();
        
        \DB::table('hazard_classes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'hazard_class_name' => 'Explosives',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            1 => 
            array (
                'id' => 2,
                'hazard_class_name' => 'Desensitized explosives',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            2 => 
            array (
                'id' => 3,
                'hazard_class_name' => 'Flammable gases',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            3 => 
            array (
                'id' => 4,
                'hazard_class_name' => 'Aerosols',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            4 => 
            array (
                'id' => 5,
                'hazard_class_name' => 'Flammable liquids',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            5 => 
            array (
                'id' => 6,
                'hazard_class_name' => 'Flammable solids',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            6 => 
            array (
                'id' => 7,
                'hazard_class_name' => 'Self-reactive substances and mixtures; Organic peroxides',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            7 => 
            array (
                'id' => 8,
                'hazard_class_name' => 'Pyrophoric liquids; Pyrophoric solids',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            8 => 
            array (
                'id' => 9,
                'hazard_class_name' => 'Self-heating substances and mixtures',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            9 => 
            array (
                'id' => 10,
                'hazard_class_name' => 'Substances and mixtures which in contact with water, emit flammable gases',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            10 => 
            array (
                'id' => 11,
                'hazard_class_name' => 'Oxidizing gases',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            11 => 
            array (
                'id' => 12,
                'hazard_class_name' => 'Oxidizing liquids; Oxidizing solids',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            12 => 
            array (
                'id' => 14,
                'hazard_class_name' => 'Gases under pressure',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            13 => 
            array (
                'id' => 15,
                'hazard_class_name' => 'Chemicals under pressure',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            14 => 
            array (
                'id' => 16,
                'hazard_class_name' => 'Corrosive to Metals',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            15 => 
            array (
                'id' => 17,
                'hazard_class_name' => 'Acute toxicity, oral',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            16 => 
            array (
                'id' => 18,
                'hazard_class_name' => 'Aspiration hazard',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            17 => 
            array (
                'id' => 19,
                'hazard_class_name' => 'Acute toxicity, dermal',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            18 => 
            array (
                'id' => 20,
                'hazard_class_name' => 'Hazardous to the ozone layer',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            19 => 
            array (
                'id' => 21,
                'hazard_class_name' => 'Hazardous to the aquatic environment, long-term hazard',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:18:01',
                'updated_at' => '2021-02-16 21:18:01',
            ),
            20 => 
            array (
                'id' => 22,
                'hazard_class_name' => 'Skin corrosion/irritation',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:30:43',
                'updated_at' => '2021-02-17 03:30:43',
            ),
            21 => 
            array (
                'id' => 23,
                'hazard_class_name' => 'Sensitization, Skin',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:53:27',
                'updated_at' => '2021-02-17 03:53:27',
            ),
            22 => 
            array (
                'id' => 24,
                'hazard_class_name' => 'Serious eye damage/eye irritation',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:57:38',
                'updated_at' => '2021-02-17 03:57:38',
            ),
            23 => 
            array (
                'id' => 25,
                'hazard_class_name' => 'Acute toxicity, inhalation',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:57:56',
                'updated_at' => '2021-02-17 03:57:56',
            ),
            24 => 
            array (
                'id' => 26,
                'hazard_class_name' => 'Sensitization',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:58:12',
                'updated_at' => '2021-02-17 09:17:29',
            ),
            25 => 
            array (
                'id' => 27,
                'hazard_class_name' => 'Reproductive toxicity',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 04:24:01',
                'updated_at' => '2021-02-17 04:24:01',
            ),
            26 => 
            array (
                'id' => 28,
                'hazard_class_name' => 'Respiratory',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:17:40',
                'updated_at' => '2021-02-17 09:17:40',
            ),
            27 => 
            array (
                'id' => 29,
                'hazard_class_name' => 'Specific target organ toxicity',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:37:26',
                'updated_at' => '2021-02-17 09:37:26',
            ),
            28 => 
            array (
                'id' => 30,
                'hazard_class_name' => 'single exposure; Respiratory tract irritation',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:37:47',
                'updated_at' => '2021-02-17 09:37:47',
            ),
            29 => 
            array (
                'id' => 31,
                'hazard_class_name' => 'single exposure; Narcotic effects',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:41:39',
                'updated_at' => '2021-02-17 09:41:39',
            ),
            30 => 
            array (
                'id' => 32,
                'hazard_class_name' => 'Germ cell mutagenicity',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:43:23',
                'updated_at' => '2021-02-17 09:43:23',
            ),
            31 => 
            array (
                'id' => 33,
                'hazard_class_name' => 'Carcinogenicity',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 09:49:21',
                'updated_at' => '2021-02-17 09:49:21',
            ),
            32 => 
            array (
                'id' => 34,
                'hazard_class_name' => 'effects on or via lactation',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 10:04:06',
                'updated_at' => '2021-02-17 10:04:06',
            ),
            33 => 
            array (
                'id' => 35,
                'hazard_class_name' => 'Hazardous to the aquatic environment',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 20:29:25',
                'updated_at' => '2021-02-17 20:29:25',
            ),
            34 => 
            array (
                'id' => 36,
                'hazard_class_name' => 'Acute hazard',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 20:29:45',
                'updated_at' => '2021-02-17 20:29:45',
            ),
            35 => 
            array (
                'id' => 37,
                'hazard_class_name' => 'Long-term hazard',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 20:34:29',
                'updated_at' => '2021-02-17 20:34:29',
            ),
        ));
        
        
    }
}
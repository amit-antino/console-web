<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 82,
                'name' => 'Germany',
                'iso3' => 'DEU',
                'iso2' => 'DE',
                'phonecode' => '49',
                'capital' => 'Berlin',
                'currency' => 'EUR',
                'native' => 'Deutschland',
                'emoji' => '🇩🇪',
                'emojiU' => 'U+1F1E9 U+1F1EA',
                'flag' => '1',
                'wikiDataId' => 'Q183',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:36',
                'updated_at' => '2021-12-02 01:53:36',
            ),
            1 => 
            array (
                'id' => 101,
                'name' => 'India',
                'iso3' => 'IND',
                'iso2' => 'IN',
                'phonecode' => '91',
                'capital' => 'New Delhi',
                'currency' => 'INR',
                'native' => 'भारत',
                'emoji' => '🇮🇳',
                'emojiU' => 'U+1F1EE U+1F1F3',
                'flag' => '1',
                'wikiDataId' => 'Q668',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:36',
                'updated_at' => '2021-12-02 01:53:36',
            ),
            2 => 
            array (
                'id' => 156,
                'name' => 'Netherlands Antilles',
                'iso3' => 'ANT',
                'iso2' => 'AN',
                'phonecode' => '',
                'capital' => '',
                'currency' => '',
                'native' => NULL,
                'emoji' => NULL,
                'emojiU' => NULL,
                'flag' => '1',
                'wikiDataId' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:36',
                'updated_at' => '2021-12-02 01:53:36',
            ),
        ));
        
        
    }
}
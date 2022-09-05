<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'Date' => '2021-12-01',
                'USD' => '1.233800',
                'JPY' => '127.030000',
                'BGN' => '1.955800',
                'CZK' => '26.145000',
                'DKK' => '7.439300',
                'GBP' => '0.906350',
                'HUF' => '357.860000',
                'PLN' => '4.516000',
                'RON' => '4.872000',
                'SEK' => '10.065300',
                'CHF' => '1.233800',
                'ISK' => '156.300000',
                'NOK' => '10.381000',
                'HRK' => '7.559500',
                'RUB' => '90.817500',
                'TRY' => '9.055400',
                'AUD' => '1.582400',
                'BRL' => '6.511900',
                'CAD' => '1.564000',
                'CNY' => '7.965300',
                'HKD' => '9.565900',
                'IDR' => '17168.200000',
                'ILS' => '3.928900',
                'INR' => '90.204000',
                'KRW' => '1339.300000',
                'MXN' => '24.354300',
                'MYR' => '4.948200',
                'NZD' => '1.691600',
                'PHP' => '59.296000',
                'SGD' => '1.624600',
                'THB' => '36.921000',
                'ZAR' => '18.512300',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-01-23 01:55:57',
                'updated_at' => '2021-01-23 01:55:57',
            ),
        ));
        
        
    }
}
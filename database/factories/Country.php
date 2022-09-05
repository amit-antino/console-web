<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        ['id' => '82', 'name' => 'Germany', 'iso3' => 'DEU', 'iso2' => 'DE', 'phonecode' => '49', 'capital' => 'Berlin', 'currency' => 'EUR', 'native' => 'Deutschland', 'emoji' => '🇩🇪', 'emojiU' => 'U+1F1E9 U+1F1EA', 'flag' => '1', 'wikiDataId' => 'Q183', 'created_by' => 1, 'updated_by' => 1, 'deleted_at' => NULL, 'created_at' => now(), 'updated_at' => now()],
        ['id' => '101', 'name' => 'India', 'iso3' => 'IND', 'iso2' => 'IN', 'phonecode' => '91', 'capital' => 'New Delhi', 'currency' => 'INR', 'native' => 'भारत', 'emoji' => '🇮🇳', 'emojiU' => 'U+1F1EE U+1F1F3', 'flag' => '1', 'wikiDataId' => 'Q668', 'created_by' => 1, 'updated_by' => 1, 'deleted_at' => NULL, 'created_at' => now(), 'updated_at' => now()],
        ['id' => '156', 'name' => 'Netherlands Antilles', 'iso3' => 'ANT', 'iso2' => 'AN', 'phonecode' => '', 'capital' => '', 'currency' => '', 'native' => NULL, 'emoji' => NULL, 'emojiU' => NULL, 'flag' => '1', 'wikiDataId' => NULL, 'created_by' => 1, 'updated_by' => 1, 'deleted_at' => NULL, 'created_at' => now(), 'updated_at' => now()]
    ];
});

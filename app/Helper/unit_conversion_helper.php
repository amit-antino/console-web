<?php

use App\Models\Country;
use App\Models\Master\Currency;
use App\Models\Master\MasterUnit;
use App\User;

function get_temperature($unit_constant_id, $value)
{
    try {
        $temperature = "";
        if ($unit_constant_id == "2") {
            $temperature = (float)($value) - 273.15;
            return number_format($temperature, 10, '.', '');
        } else if ($unit_constant_id == "3") {
            $temperature = (float) (($value - 32) / 1.8);
            return number_format($temperature, 10, '.', '');
        } else {
            return number_format($value, 10, '.', '');
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_density($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 8;
    }
    $density_kg_m3 = "";
    if ($unit_constant_id == "1") {
        $density_kg_m3 = (float)(($value * 1000) / 1);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $density_kg_m3 = (float)(($value * 1000) / 1);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $density_kg_m3 = (float)(($value * 1000) / 1000);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $density_kg_m3 = (float)(($value * 1000) / 3785.41075733872);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $density_kg_m3 = $value;
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $density_kg_m3 = (float)(($value * 1000) / 0.03612729937834222);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $density_kg_m3 = (float)(($value * 1000) / 62.4279737253144);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $density_kg_m3 = (float)(($value * 1000) / 8.34540898438427);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $density_kg_m3 = (float)(($value * 1000) / 350.507102430571);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "10") {
        $density_kg_m3 = (float)(($value * 1000) / 0.578036777567881);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "11") {
        $density_kg_m3 = (float)(($value * 1000) / 133.526506293364);
        return number_format($density_kg_m3, 10, '.', '');
    } else if ($unit_constant_id == "12") {
        $density_kg_m3 = (float)(($value * 1000) / 1);
        return number_format($density_kg_m3, 10, '.', '');
    } else {
        return 0;
    }
}

function get_mass($unit_constant_id, $value)
{
    try {
        $mass_kg = "";
        if ($unit_constant_id == "1") {
            $mass_kg = (float)(($value * 1) / 0.00098421);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "2") {
            $mass_kg = (float)(($value * 1) / 0.0011023);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "3") {
            $mass_kg = (float)(($value * 1) / 0.001);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "4") {
            $mass_kg = (float)(($value * 1) / 2.2046);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "5") {
            $mass_kg = (float)(($value * 1) / 35.274);
            return number_format($mass_kg, 10, '.', '');
        } else	if ($unit_constant_id == "6") {
            $mass_kg = $value;
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "7") {
            $mass_kg = (float)(($value * 1) / 1000);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "8") {
            $mass_kg = (float)(($value * 1) / 1000000);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "9") {
            $mass_kg = (float)(($value * 1) / 15432);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "10") {
            $mass_kg = (float)(($value * 1) / 5000);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "11") {
            $mass_kg = (float)(($value * 1) / 0.0685218);
            return number_format($mass_kg, 10, '.', '');
        } else if ($unit_constant_id == "12") {
            $mass_kg = (float)(($value * 1) / 0.001);
            return number_format($mass_kg, 10, '.', '');
        } else {
            return 0;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_pressure($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 47;
    }
    $pressure = "";
    if ($unit_constant_id == "1") {
        $pressure = (float)(($value * 1) / 0.000145038);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $pressure = (float)(($value) / 0.00401865);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "3") {
        $pressure = (float)($value / 0.0002953);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $pressure = (float)(($value) / 0.00750062);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $pressure = (float)(($value) / 0.00000986923);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $pressure = (float)($value * 1000000);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $pressure = (float)(($value) / 10);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $pressure = (float)(($value * 1000000000));
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $pressure = (float)(($value) / 0.00001);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "10") {
        $pressure = (float)(($value) / 0.00033455256555148);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "11") {
        $pressure = (float)(($value) / 0.00750062);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "12") {
        $pressure = $value / 0.01;
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "13") {
        $pressure = $value / 0.0000101972;
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "14") {
        $pressure = $value / 0.001;
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "15") {
        $pressure = $value;
        return number_format($pressure, 10, '.', '');
    }
}

function get_time($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 51;
    }
    $days = "";
    if ($unit_constant_id == "1") {
        $days = (float)(($value * 0.041666667) / 3600);
        return number_format($days, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $days = (float)(($value * 0.041666667) / 60);
        return number_format($days, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $days = (float)(($value * 0.041666667) / 1);
        return number_format($days, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $days = $value;
        return number_format($days, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $days = (float)(($value * 0.041666667) / 0.005952381);
        return number_format($days, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $days = (float)(($value * 0.041666667) / 0.0001142);
        return number_format($days, 10, '.', '');
    } else {
        return 0;
    }
}

function get_molar_energy($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 67;
    }
    $molar_energy = "";
    if ($unit_constant_id == "1") {
        $molar_energy = (float)(($value * 0.002326) / 1);
        return number_format($molar_energy, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $molar_energy = (float)(($value * 0.002326) / 0.5555556);
        return number_format($molar_energy, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $molar_energy = (float)(($value * 0.002326) / 2.326);
        return number_format($molar_energy, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $molar_energy = $value;
        return number_format($molar_energy, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $molar_energy = (float)(($value * 0.002326) / 0.0000000023);
        return number_format($molar_energy, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $molar_energy = (float)(($value * 0.002326) / 0.0000000023);
        return number_format($molar_energy, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $molar_energy = (float)(($value * 0.002326) / 0.5555556);
        return number_format($molar_energy, 10, '.', '');
    } else	if ($unit_constant_id == "8") {
        $molar_energy = (float)(($value * 0.002326) / 2326);
        return number_format($molar_energy, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $molar_energy = (float)(($value * 0.002326) / 2.326);
        return number_format($molar_energy, 10, '.', '');
    } else	if ($unit_constant_id == "10") {
        $molar_energy = (float)(($value * 0.002326) / 0.002326);
        return number_format($molar_energy, 10, '.', '');
    } else {
        return 0;
    }
}

function get_carbon_content($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 56;
    }
    $carbon_content = "";
    if ($unit_constant_id == "1") {
        $carbon_content = (float)(($value * 1) / 0.001);
        return number_format($carbon_content, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $carbon_content = $value;
        return number_format($carbon_content, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $carbon_content = (float)(($value * 1) / 1000);
        return number_format($carbon_content, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $carbon_content = (float)(($value * 1) / 1);
        return number_format($carbon_content, 10, '.', '');
    }
    if ($unit_constant_id == "5") {
        $carbon_content = (float)(($value * 1) / 1000);
        return number_format($carbon_content, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $carbon_content = (float)(($value * 1) / 1000000);
        return number_format($carbon_content, 10, '.', '');
    } else	if ($unit_constant_id == "7") {
        $carbon_content = (float)(($value * 1) / 0.000001);
        return number_format($carbon_content, 10, '.', '');
    } else	if ($unit_constant_id == "8") {
        $carbon_content = (float)(($value * 1) / 0.001);
        return number_format($carbon_content, 10, '.', '');
    } else	if ($unit_constant_id == "9") {
        $carbon_content = (float)(($value * 1) / 1);
        return number_format($carbon_content, 10, '.', '');
    } else {
        return 0;
    }
}
////not set
function get_ld50($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 76;
    }
    $ld_50 = "";
    if ($unit_constant_id == "1") {
        $ld_50 = (float)(($value * 1000000) / 1);
        return number_format($ld_50, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $ld_50 = (float)(($value * 1000000) / 1000);
        return number_format($ld_50, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $ld_50 = $value;
        return number_format($ld_50, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $ld_50 = (float)(($value * 1000000) / 0.001);
        return number_format($ld_50, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $ld_50 = (float)(($value * 1000000) / 1);
        return number_format($ld_50, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $ld_50 = (float)(($value * 1000000) / 1000);
        return number_format($ld_50, 10, '.', '');
    } else	if ($unit_constant_id == "7") {
        $ld_50 = (float)(($value * 1000000) / 0.000001);
        return number_format($ld_50, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $ld_50 = (float)(($value * 1000000) / 0.001);
        return number_format($ld_50, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $ld_50 = (float)(($value * 1000000) / 1);
        return number_format($ld_50, 10, '.', '');
    } else {
        return 0;
    }
}

function specific_energy($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 23;
    }
    $se = "";
    if ($unit_constant_id == "1") {
        $se = number_format((float)(($value * 0.002326) / 1), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $se = number_format((float)(($value * 0.002326) / 0.5555556), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $se = number_format((float)(($value * 0.002326) / 2.326), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $se = number_format((float)(($value * 0.002326) / 555.5556), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $se = number_format((float)(($value * 0.002326) / 0.5555556), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $se = number_format((float)(($value * 0.002326) / 2326), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $se = number_format((float)(($value * 0.002326) / 2.326), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $val = number_format((float)($value), 10, '.', '');
        $se = number_format((float)(($val * 0.002326) / 0.002326), 10, '.', '');
        return $se;
    } else	if ($unit_constant_id == "9") {
        $se = number_format((float)(($value * 0.002326) / 0.002326), 10, '.', '');
        return number_format($se, 10, '.', '');
    } else {
        return 0;
    }
}

function get_weight_concentration($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 83;
    }
    $weight = "";
    if ($unit_constant_id == "1") {
        $weight = (float)(($value * 0.000001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $weight = (float)(($value * 1000000000) / 1000000);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "3") {
        $weight = (float)(($value * 1000000000) / 1000);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $weight = (float)(($value * 1000000000) / 1);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $weight = (float)(($value * 1000000000) / 1000);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $weight = (float)(($value * 1000000000) / 1000000000);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $weight = (float)(($value * 1000000000) / 1000000);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $weight = (float)(($value * 1000000000) / 2204.62247603796);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $weight = (float)(($value * 1000000000) / 2000);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "10") {
        $weight = (float)(($value * 1000000000) / 2679.22903576958);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "11") {
        $weight = (float)(($value * 1000000000) / 10.0224128549605);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "12") {
        $weight = (float)(($value * 1000000000) / 8.34540445201931);
        return  number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "13") {
        $weight = (float)(($value * 1000000000) / 9.71110640785247);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "14") {
        $weight = (float)(($value * 1000000000) / 1000000);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "15") {
        $weight = (float)(($value * 1000000000) / 1000000000);
        return number_format($weight, 10, '.', '');
    } else {
        return 0;
    }
}

///not set
function get_weight_concentration_mper3($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 162;
    }
    $weight = "";
    if ($unit_constant_id == "1") {
        $weight = (float)(($value * 0.000001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "2") {
        $weight = (float)(($value * 0.000001) / 0.000001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $weight = (float)(($value * 0.000001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $weight = (float)(($value * 0.000001) / 1);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $weight = (float)(($value * 0.000001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $weight = (float)(($value * 0.000001) / 0.000000001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $weight = (float)(($value * 0.000001) / 0.000001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $weight = (float)(($value * 0.000001) / 0.0004535924);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $weight = (float)(($value * 0.000001) / 0.0005);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "10") {
        $weight = (float)(($value * 0.000001) / 0.0003732417);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "11") {
        $weight = (float)(($value * 0.000001) / 0.0997763726631017);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "12") {
        $weight = (float)(($value * 0.000001) / 0.119826427316897);
        return  number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "13") {
        $weight = (float)(($value * 0.000001) / 0.102974878247796);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "14") {
        $weight = $value;
        return number_format($weight, 10, '.', '');
    } else {
        return 0;
    }
}
///not set
function get_pressure_process($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 46;
    }
    $pressure = "";
    if ($unit_constant_id == "1") {
        $pressure = (float)(($value * 6.894757) / 1);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $pressure = (float)(($value * 6.894757) / 2.041772);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $pressure = (float)(($value * 6.894757) / 51.71508);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $pressure = (float)(($value * 6.894757) / 2.308966);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $pressure = (float)(($value * 6.894757) / 27.70759);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $pressure = (float)(($value * 6.894757) / 51.71508);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "7") {
        $pressure = (float)(($value * 6.894757) / 0.06804596);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "8") {
        $pressure = (float)(($value * 6.894757) / 0.06894757);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "9") {
        $pressure = (float)(($value * 6.894757) / 68.94757);
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "10") {
        $pressure = (float)(($value * 6.894757) / 0.07030696);
        return number_format($pressure, 10, '.', '');
    } else if ($unit_constant_id == "11") {
        $pressure = $value;
        return number_format($pressure, 10, '.', '');
    } else	if ($unit_constant_id == "12") {
        $pressure = (float)(($value * 6.894757) / 6894.757);
        return number_format($pressure, 10, '.', '');
    } else {
        return 0;
    }
}
///not set
function get_cat($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 159;
    }
    $hour = "";
    if ($unit_constant_id == "1") {
        $hour = (float)(($value * 1) / 0.000278);
        return number_format($hour, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $hour = (float)(($value * 1) / 0.01667);
        return number_format($hour, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $hour = $value;
        return number_format($hour, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $hour = (float)(($value * 1) / 24);
        return number_format($hour, 10, '.', '');
    }
}
///not set
function get_time_minutes($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 49;
    }
    $days = "";
    if ($unit_constant_id == "1") {
        $days = (float)(($value * 60) / 3600);
        return number_format($days, 10, '.', '');
    } else	if ($unit_constant_id == "2") {
        $days = $value;
        return number_format($days, 10, '.', '');
    } else	if ($unit_constant_id == "3") {
        $days = (float)(($value * 60) / 1);
        return number_format($days, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $days = (float)(($value * 60) / 0.041666667);
        return number_format($days, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $days = (float)(($value * 60) / 0.005952381);
        return number_format($days, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $days = (float)(($value * 60) / 0.0001142);
        return number_format($days, 10, '.', '');
    }
}
///not set
function get_time_seconds($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 48;
    }
    $minutes = "";
    if ($unit_constant_id == "1") {
        $minutes = $value;
        return number_format($minutes, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $minutes = (float)(($value * 3600) / 60);
        return number_format($minutes, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $minutes = (float)(($value * 3600) / 1);
        return number_format($minutes, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $minutes = (float)(($value * 3600) / 0.0416666667);
        return number_format($minutes, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $minutes = (float)(($value * 3600) / 0.005952381);
        return number_format($minutes, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $minutes = (float)(($value * 3600) / 0.0001142);
        return number_format($minutes, 10, '.', '');
    } else {
        return 0;
    }
}

function mass_flow_rate($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 102;
    }
    $kg_pr_hour = "";
    if ($unit_constant_id == "1") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.0002777778);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "2") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.01666667);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "3") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 1);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "4") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 24);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "5") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.0001259979);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "6") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.007559873);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "7") {
        $kg_pr_hour = $value;
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "8") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 10.8862176);
        return number_format($kg_pr_hour, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.0197142864);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "10") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.012);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "11") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.01088621276);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "12") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 3976.10583);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "13") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.000000125997881);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "14") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.00000755987268);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "15") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.000453592374);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "16") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 0.0108862169);
        return number_format($kg_pr_hour, 10, '.', '');
    } else	if ($unit_constant_id == "17") {
        $kg_pr_hour = (float)(($value * 0.4535924) / 3.97610583);
        return number_format($kg_pr_hour, 10, '.', '');
    } else {
        return 0;
    }
}

function get_weight_concentration_process($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 85;
    }
    $weight = "";
    if ($unit_constant_id == "83") {
        $weight = (float)(($value * 0.001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "84") {
        $weight = (float)(($value * 0.001) / 0.000001);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "85") {
        $weight = $value;
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "86") {
        $weight = (float)(($value * 0.001) / 1);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "87") {
        $weight = (float)(($value * 0.001) / 0.001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "88") {
        $weight = (float)(($value * 0.001) / 0.000000001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "89") {
        $weight = (float)(($value * 0.001) / 0.000001);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "90") {
        $weight = (float)(($value * 0.001) / 0.0004535924);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "91") {
        $weight = (float)(($value * 0.001) / 0.0005);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "92") {
        $weight = (float)(($value * 0.001) / 0.0003732417);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "93") {
        $weight = (float)(($value * 0.001) / 0.0997763726631017);
        return number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "94") {
        $weight = (float)(($value * 0.001) / 0.119826427316897);
        return  number_format($weight, 10, '.', '');
    } else	if ($unit_constant_id == "95") {
        $weight = (float)(($value * 0.001) / 0.102974878247796);
        return number_format($weight, 10, '.', '');
    } else if ($unit_constant_id == "162") {
        $weight = (float)(($value * 0.001) / 0.000001);
        return number_format($weight, 10, '.', '');
    } else {
        return 0;
    }
}

function get_power($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 307;
    }
    $power_MJ_hr = "";
    if ($unit_constant_id == "1") {
        $power_MJ_hr = (float)(($value * 0.0036) / 1);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "2") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.000000001);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "3") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.000001);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "4") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.001);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "5") {
        $power_MJ_hr = (float)(($value * 0.0036) / 1000);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "6") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.001341022);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "7") {
        $power_MJ_hr = (float)(($value * 0.0036) / 3.41442595);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "8") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.000948452);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "9") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.000238846);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "10") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.238845897);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "11") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.000001);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "12") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.0036);
        return number_format($power_MJ_hr, 10, '.', '');
    } else  if ($unit_constant_id == "13") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.00006);
        return number_format($power_MJ_hr, 10, '.', '');
    } else if ($unit_constant_id == "14") {
        $power_MJ_hr = (float)(($value * 0.0036) / 0.0000036);
        return number_format($power_MJ_hr, 10, '.', '');
    } else {
        return 0;
    }
}

function get_volumentric_flowrate($unit_constant_id, $value, $return_default_unit = false)
{
    if ($return_default_unit == true) {
        return 129;
    }
    $vol_pr_hour = "";
    if ($unit_constant_id == "1") {
        $vol_pr_hour = (float)(($value * 101.9407));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "2") {
        $vol_pr_hour = (float)(($value * 1.699011));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "3") {
        $vol_pr_hour = (float)(($value) / 35.315);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "4") {
        $vol_pr_hour = (float)(($value) / 6.29);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "5") {
        $vol_pr_hour = (float)(($value) / 151);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "6") {
        $vol_pr_hour = (float)(($value) / 4.430);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "7") {
        $vol_pr_hour = (float)(($value) / 6340);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "8") {
        $vol_pr_hour = (float)(($value * 3600));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "9") {
        $vol_pr_hour = (float)(($value * 60));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "10") {
        $vol_pr_hour = (float)(($value));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "11") {
        $vol_pr_hour = (float)(($value * 3.6));
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "12") {
        $vol_pr_hour = (float)(($value) / 16.667);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "13") {
        $vol_pr_hour = (float)(($value) / 1000);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "14") {
        $vol_pr_hour = (float)(($value) / 24000);
        return number_format($vol_pr_hour, 10, '.', '');
    } else {
        return 0;
    }
}

function get_currency($date, $unit_constant_id, $currency_value, $destination_curency = "", $extra_param = array(), $user_id)
{
    $units = MasterUnit::where('id', 19)->first();
    $unit_constant = !empty($units['unit_constant']) ? $units['unit_constant'] : [];
    $unitConstantName = '';
    foreach ($unit_constant as $constant) {
        if ($constant['id'] == $unit_constant_id) {
            $unitConstantName = $constant['unit_symbol'];
            break;
        }
    }
    $source_currency = $unitConstantName;
    $user = User::where('id', $user_id)->first();
    if ($destination_curency == "") {
        if (!empty($user->id)) {
            return number_format($currency_value, 10, '.', '');
        }
        $country = Country::where('id', $user->currency_type)->first();
        $currency_name = $country->currency;
        if (empty($currency_name)) {
            $destination_curency = "USD";
        } else {
            $destination_curency = $currency_name;
        }
    }
    if ($destination_curency == $source_currency) {
        return number_format($currency_value, 10, '.', '');
    }
    $cur_re = Currency::where('Date', $date)->orderBy('id', 'desc')->first();
    //its not currency . its the quantity value
    if (!isset($cur_re["$source_currency"])) {
        return $currency_value;
    }
    $ac_val = "";
    if ($destination_curency == "USD") {
        $ac_val = $currency_value / $cur_re["$source_currency"];
    } else {
        $ac_val = $currency_value / $cur_re["$source_currency"];
        $ac_val = $ac_val * $cur_re["$destination_curency"];
    }
        $ac_val = $ac_val * $cur_re["$destination_curency"];
   // dd($ac_val);
    return number_format($ac_val, 10, '.', '');
}

function get_dynamic_viscosity($unit_constant_id, $value)
{
    $vol_pr_hour = "";
    if ($unit_constant_id == "1") {
        $vol_pr_hour = (float)(($value * 101.9407) / 1.0);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "2") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0000009113444);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "3") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0009113444);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "4") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.00005468066);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "5") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0546806649168854);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "6") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.00328083989501312);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "7") {
        $vol_pr_hour = (float)(($value * 101.9407) / 3.28083989501312);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "8") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0000002777778);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "9") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0002777778);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "10") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.00001666667);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "11") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.0166666666666667);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "12") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.001);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "13") {
        $vol_pr_hour = (float)(($value * 101.9407) / 1);
        return number_format($vol_pr_hour, 10, '.', '');
    }
    if ($unit_constant_id == "14") {
        $vol_pr_hour = (float)(($value * 101.9407) / 0.1);
        return number_format($vol_pr_hour, 10, '.', '');
    } else {
        return 0;
    }
}

function get_default_value($unit_constant_id, $value)
{
    $vol_pr_hour = "";
    $vol_pr_hour = (float)$value;
    return number_format($vol_pr_hour, 10, '.', '');
}

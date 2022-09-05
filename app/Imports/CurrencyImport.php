<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Master\Currency;

class CurrencyImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key != 0) {
                Currency::create([
                    'Date'     => date('Y-m-d'),
                    'USD'     => $row[1],
                    'JPY'     => $row[2],
                    'BGN'     => $row[3],
                    'CZK'     => $row[4],
                    'DKK'     => $row[5],
                    'GBP'     => $row[6],
                    'HUF'     => $row[7],
                    'PLN'     => $row[8],
                    'RON'     => $row[9],
                    'SEK'     => $row[10],
                    'CHF'     => $row[1],
                    'ISK'     => $row[12],
                    'NOK'     => $row[13],
                    'HRK'     => $row[14],
                    'RUB'     => $row[15],
                    'TRY'     => $row[16],
                    'AUD'     => $row[17],
                    'BRL'     => $row[18],
                    'CAD'     => $row[19],
                    'CNY'     => $row[20],
                    'HKD'     => $row[21],
                    'IDR'     => $row[22],
                    'ILS'     => $row[23],
                    'INR'     => $row[24],
                    'KRW'     => $row[25],
                    'MXN'     => $row[26],
                    'MYR'     => $row[27],
                    'NZD'     => $row[28],
                    'PHP'     => $row[29],
                    'SGD'     => $row[30],
                    'THB'     => $row[31],
                    'ZAR'     => $row[32],
                    'created_by'     => \Auth::user()->id,
                    'updated_by'     => \Auth::user()->id,
                ]);
            }
        }
    }
}

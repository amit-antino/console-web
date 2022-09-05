<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SimTemplateImport implements Collection
{
    public function collection(Collection $collection)
    {
        dd($collection);
    } 
}


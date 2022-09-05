<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $addHttpCookie = true;

    protected $except = [
        'add-more-chemicals-field',
        'admin/master/chemical/unit_type/add-more-constant-field',
        'experiment/data_set/raw_material/add_more_product'
    ];
}

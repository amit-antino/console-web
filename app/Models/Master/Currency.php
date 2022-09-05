<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['Date','USD','JPY','BGN','CZK','DKK','GBP','HUF','PLN','RON','SEK','CHF','ISK','NOK','HRK','RUB','TRY','AUD','BRL','CAD','CNY','HKD','IDR','ILS','INR','KRW','MXN','MYR','NZD','PHP','SGD','THB','ZAR','created_by','updated_by'];
}

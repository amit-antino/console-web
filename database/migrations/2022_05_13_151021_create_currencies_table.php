<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('Date');
            $table->decimal('USD', 12, 6)->default(0);
            $table->decimal('JPY', 12, 6)->default(0);
            $table->decimal('BGN', 12, 6)->default(0);
            $table->decimal('CZK', 12, 6)->default(0);
            $table->decimal('DKK', 12, 6)->default(0);
            $table->decimal('GBP', 12, 6)->default(0);
            $table->decimal('HUF', 12, 6)->default(0);
            $table->decimal('PLN', 12, 6)->default(0);
            $table->decimal('RON', 12, 6)->default(0);
            $table->decimal('SEK', 12, 6)->default(0);
            $table->decimal('CHF', 12, 6)->default(0);
            $table->decimal('ISK', 12, 6)->default(0);
            $table->decimal('NOK', 12, 6)->default(0);
            $table->decimal('HRK', 12, 6)->default(0);
            $table->decimal('RUB', 12, 6)->default(0);
            $table->decimal('TRY', 12, 6)->default(0);
            $table->decimal('AUD', 12, 6)->default(0);
            $table->decimal('BRL', 12, 6)->default(0);
            $table->decimal('CAD', 12, 6)->default(0);
            $table->decimal('CNY', 12, 6)->default(0);
            $table->decimal('HKD', 12, 6)->default(0);
            $table->decimal('IDR', 12, 6)->default(0);
            $table->decimal('ILS', 12, 6)->default(0);
            $table->decimal('INR', 12, 6)->default(0);
            $table->decimal('KRW', 12, 6)->default(0);
            $table->decimal('MXN', 12, 6)->default(0);
            $table->decimal('MYR', 12, 6)->default(0);
            $table->decimal('NZD', 12, 6)->default(0);
            $table->decimal('PHP', 12, 6)->default(0);
            $table->decimal('SGD', 12, 6)->default(0);
            $table->decimal('THB', 12, 6)->default(0);
            $table->decimal('ZAR', 12, 6)->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}

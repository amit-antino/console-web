<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCreationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_creations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('process_id')->nullable();
            $table->integer('simulation_type')->nullable();
            $table->integer('new_product_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('stream_id')->nullable();
            $table->string('datasource')->nullable();
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
        Schema::dropIfExists('product_creations');
    }
}

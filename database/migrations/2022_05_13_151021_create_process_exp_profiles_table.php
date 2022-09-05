<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessExpProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_exp_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('process_exp_id');
            $table->integer('variation_id')->default(0);
            $table->integer('experiment_unit');
            $table->json('condition')->nullable();
            $table->json('outcome')->nullable();
            $table->json('reaction')->nullable();
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
        Schema::dropIfExists('process_exp_profiles');
    }
}

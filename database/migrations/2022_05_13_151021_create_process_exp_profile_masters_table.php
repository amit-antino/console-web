<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessExpProfileMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_exp_profile_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('process_exp_id');
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
        Schema::dropIfExists('process_exp_profile_masters');
    }
}
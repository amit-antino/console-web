<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reaction_id')->nullable();
            $table->json('properties')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('type', ['rate_parameter', 'equilibrium'])->default('rate_parameter');
            $table->enum('sub_type', ['user_input', 'calculation'])->default('user_input');
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
        Schema::dropIfExists('reaction_properties');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_curations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('data_set_id')->default(0);
            $table->integer('curation_rule_id')->default(0);
            $table->string('data_set_experiment_id')->nullable();
            $table->string('variation_coeficient')->default('0');
            $table->string('smoothness_factor')->default('0');
            $table->string('csv_file')->nullable();
            $table->longText('message')->nullable();
            $table->json('output')->nullable();
            $table->enum('status', ['pending', 'failure', 'success'])->default('pending');
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
        Schema::dropIfExists('data_curations');
    }
}

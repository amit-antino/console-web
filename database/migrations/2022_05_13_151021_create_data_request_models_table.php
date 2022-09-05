<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRequestModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_request_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('process_experiment_id')->default(0);
            $table->integer('model_id')->default(0);
            $table->integer('simulation_input_id')->default(0);
            $table->string('filename')->nullable();
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('flag')->default(0);
            $table->enum('status', ['requested', 'under_process', 'processed'])->default('requested');
            $table->enum('operation_status', ['active', 'inactive', 'pending'])->default('active');
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
        Schema::dropIfExists('data_request_models');
    }
}

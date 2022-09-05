<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataset_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('name');
            $table->integer('process_experiment_id')->default(0);
            $table->integer('type')->default(0);
            $table->integer('model_id')->default(0);
            $table->string('filename')->nullable();
            $table->longText('description')->nullable();
            $table->longText('update_notes')->nullable();
            $table->longText('update_parameter')->nullable();
            $table->json('tags')->nullable();
            $table->enum('status', ['requested', 'under_process', 'processed'])->default('requested');
            $table->enum('operation_status', ['active', 'inactive', 'pending'])->default('active');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('flag')->default(0);
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
        Schema::dropIfExists('dataset_models');
    }
}

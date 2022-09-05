<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessExperimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_experiments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('project_id')->default(0);
            $table->string('process_experiment_name');
            $table->integer('category_id');
            $table->json('experiment_unit')->nullable();
            $table->json('classification_id');
            $table->json('chemical');
            $table->string('data_source')->nullable();
            $table->json('main_product_input');
            $table->json('main_product_output');
            $table->json('energy_id')->nullable();
            $table->longText('description')->nullable();
            $table->json('tags')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
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
        Schema::dropIfExists('process_experiments');
    }
}

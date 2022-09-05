<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperimentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiment_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('name');
            $table->integer('experiment_id');
            $table->integer('variation_id');
            $table->integer('simulation_input_id');
            $table->integer('report_type')->default(0);
            $table->json('output_data')->nullable();
            $table->string('messages')->nullable();
            $table->integer('job_id')->nullable()->default(0);
            $table->integer('queue_id')->nullable()->default(0);
            $table->enum('status', ['success', 'pending', 'failure'])->default('pending');
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
        Schema::dropIfExists('experiment_reports');
    }
}

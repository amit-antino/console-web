<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessSimulationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_simulation_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('report_name')->nullable();
            $table->enum('report_type', ['standard', 'custom'])->default('standard');
            $table->string('process_simulation_id')->nullable();
            $table->string('simulation_type')->nullable();
            $table->string('description')->nullable();
            $table->json('tags')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
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
        Schema::dropIfExists('process_simulation_reports');
    }
}

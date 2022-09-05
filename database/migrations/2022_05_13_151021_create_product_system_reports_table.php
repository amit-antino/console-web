<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSystemReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_system_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('report_name');
            $table->string('report_type')->nullable();
            $table->integer('product_system_id');
            $table->json('process_simulation_ids')->nullable();
            $table->integer('number_of_process')->default(0);
            $table->json('output_data')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('product_system_reports');
    }
}

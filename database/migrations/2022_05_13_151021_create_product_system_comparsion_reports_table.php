<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSystemComparsionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_system_comparsion_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('report_name');
            $table->string('report_type');
            $table->integer('product_system_id');
            $table->json('tags')->nullable();
            $table->json('output_data')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('product_system_comparsion_reports');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulateInputExcelTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulate_input_excel_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('variation_id');
            $table->integer('simulate_id')->default(0);
            $table->string('template_name', 500);
            $table->json('raw_material')->nullable();
            $table->json('master_conditions')->nullable();
            $table->json('exp_unit_conditions')->nullable();
            $table->json('master_outcomes')->nullable();
            $table->json('exp_unit_outcomes')->nullable();
            $table->string('description', 500)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('simulate_input_excel_templates');
    }
}

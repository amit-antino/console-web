<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulateInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulate_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->nullable()->default(0);
            $table->integer('tenant_id')->default(0);
            $table->integer('template_id')->default(0);
            $table->string('name')->nullable();
            $table->integer('experiment_id')->default(0);
            $table->integer('variation_id')->default(0);
            $table->enum('simulate_input_type', ['reverse', 'forward'])->default('forward');
            $table->json('raw_material')->nullable();
            $table->json('master_condition')->nullable();
            $table->json('master_outcome')->nullable();
            $table->json('unit_condition')->nullable();
            $table->json('unit_outcome')->nullable();
            $table->json('simulation_type')->nullable();
            $table->longText('notes')->nullable();
            $table->string('note_urls')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('prev_status', ['active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('simulate_inputs');
    }
}

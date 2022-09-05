<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessSimulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_simulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('process_name');
            $table->integer('process_type')->nullable();
            $table->json('product');
            $table->json('energy')->nullable();
            $table->string('main_feedstock');
            $table->string('simulation_type')->default('1');
            $table->string('main_product');
            $table->integer('process_category')->nullable();
            $table->integer('process_status')->nullable();
            $table->json('sim_stage')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description')->nullable();
            $table->integer('knowledge_bank')->default(0);
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
        Schema::dropIfExists('process_simulations');
    }
}

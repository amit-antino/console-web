<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessComaprisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_comaprisons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('report_name');
            $table->string('report_type');
            $table->integer('simulation_type');
            $table->json('process_simulation_ids');
            $table->integer('mass_balance')->default(0);
            $table->integer('energy_balance')->default(0);
            $table->json('output_data')->nullable();
            $table->json('tags')->nullable();
            $table->json('specify_weights')->nullable();
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
        Schema::dropIfExists('process_comaprisons');
    }
}

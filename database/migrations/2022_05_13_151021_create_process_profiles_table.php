<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('process_id');
            $table->string('dataset_name')->default('');
            $table->json('data_source')->nullable();
            $table->string('simulation_type')->nullable();
            $table->json('mass_basic_io')->nullable();
            $table->json('mass_basic_pc')->nullable();
            $table->json('mass_basic_pd')->nullable();
            $table->json('energy_basic_io')->nullable();
            $table->json('energy_process_level')->nullable();
            $table->json('energy_detailed_level')->nullable();
            $table->json('equipment_capital_cost')->nullable();
            $table->json('key_process_info')->nullable();
            $table->json('quality_assesment')->nullable();
            $table->string('data_source_mass')->default('0');
            $table->string('data_source_energy')->default('0');
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
        Schema::dropIfExists('process_profiles');
    }
}

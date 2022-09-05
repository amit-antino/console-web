<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_utilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('energy_name')->nullable();
            $table->integer('base_unit_type')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description')->nullable();
            $table->json('prop_technical')->nullable();
            $table->json('prop_sustain_info')->nullable();
            $table->json('prop_comm_info')->nullable();
            $table->json('prop_notes')->nullable();
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
        Schema::dropIfExists('energy_utilities');
    }
}

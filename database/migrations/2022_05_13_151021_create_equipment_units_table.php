<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('model_id')->default(0);
            $table->string('equipment_name')->nullable();
            $table->json('outcome')->nullable();
            $table->json('condition')->nullable();
            $table->json('stream_flow')->nullable();
            $table->integer('unit_image')->nullable();
            $table->longText('description')->nullable();
            $table->json('tags')->nullable();
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
        Schema::dropIfExists('equipment_units');
    }
}

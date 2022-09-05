<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('equipment_name')->nullable();
            $table->string('installation_date')->nullable();
            $table->string('purchased_date')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('equipment_image')->nullable();
            $table->enum('availability', ['true', 'false'])->default('false');
            $table->string('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('equipments');
    }
}

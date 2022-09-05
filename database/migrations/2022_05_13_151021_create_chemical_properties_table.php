<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChemicalPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemical_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tenant_id')->default(0);
            $table->integer('product_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('sub_property_id')->nullable();
            $table->json('prop_json')->nullable();
            $table->json('dynamic_prop_json')->nullable();
            $table->integer('order_by')->nullable();
            $table->enum('recommended', ['on', 'off'])->default('on');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
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
        Schema::dropIfExists('chemical_properties');
    }
}

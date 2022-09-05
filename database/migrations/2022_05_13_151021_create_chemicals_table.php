<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChemicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('chemical_name');
            $table->integer('product_type_id')->default(0);
            $table->string('molecular_formula')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('classification_id')->nullable();
            $table->json('smiles')->nullable();
            $table->string('product_brand_name')->nullable();
            $table->longText('notes')->nullable();
            $table->json('cas_no')->nullable();
            $table->string('iupac')->nullable();
            $table->string('inchi')->nullable();
            $table->string('inchi_key')->nullable();
            $table->longText('other_name')->nullable();
            $table->json('tags')->nullable();
            $table->json('vendor_list')->nullable();
            $table->longText('ec_number')->nullable();
            $table->boolean('own_product')->default(false);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('chemicals');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('list_id')->nullable();
            $table->string('chemical_name', 500)->nullable();
            $table->string('other_name', 500)->nullable();
            $table->string('molecular_formula')->nullable();
            $table->json('cas')->nullable();
            $table->string('iupac')->nullable();
            $table->string('inchi_key')->nullable();
            $table->string('smiles')->nullable();
            $table->string('list_name')->nullable();
            $table->string('source')->nullable();
            $table->text('organization')->nullable();
            $table->text('external_link')->nullable();
            $table->string('ec_number')->nullable();
            $table->string('groups')->nullable();
            $table->string('hazard_class')->nullable();
            $table->string('hazard_code')->nullable();
            $table->string('hazard_statement')->nullable();
            $table->string('hazard_category')->nullable();
            $table->string('eu_hazard_statement')->nullable();
            $table->string('usage_app_category')->nullable();
            $table->text('technical_fun')->nullable();
            $table->text('possible_usage')->nullable();
            $table->text('monitoring_data')->nullable();
            $table->text('rsl_limits_table')->nullable();
            $table->text('product_line_restriction')->nullable();
            $table->text('specific_restriction')->nullable();
            $table->string('numeric_limit')->nullable();
            $table->text('test_methods')->nullable();
            $table->text('substi_option')->nullable();
            $table->text('notes')->nullable();
            $table->date('date_of_inclusion')->nullable();
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
        Schema::dropIfExists('list_products');
    }
}

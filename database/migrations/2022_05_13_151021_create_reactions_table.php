<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('reaction_name')->nullable();
            $table->string('reaction_source')->nullable();
            $table->string('reaction_type')->nullable();
            $table->longText('description')->nullable();
            $table->json('tags')->nullable();
            $table->json('reactant_component')->nullable();
            $table->json('product_component')->nullable();
            $table->json('chemical_reaction_left')->nullable();
            $table->json('chemical_reaction_right')->nullable();
            $table->json('reaction_reactant')->nullable();
            $table->json('reaction_product')->nullable();
            $table->longText('notes')->nullable();
            $table->string('balance')->nullable();
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
        Schema::dropIfExists('reactions');
    }
}

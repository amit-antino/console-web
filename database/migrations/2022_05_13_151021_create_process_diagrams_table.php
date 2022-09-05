<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessDiagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_diagrams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('clone_id')->default(0);
            $table->integer('tenant_id')->default(0);
            $table->string('name');
            $table->integer('process_id');
            $table->integer('flowtype');
            $table->json('from_unit')->nullable();
            $table->json('to_unit')->nullable();
            $table->integer('openstream')->default(0);
            $table->json('products')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
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
        Schema::dropIfExists('process_diagrams');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHazardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hazards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('hazard_class_id')->nullable();
            $table->json('category_id')->nullable();
            $table->bigInteger('pictogram_id')->nullable();
            $table->json('code_statement_id')->nullable();
            $table->string('signal_word')->nullable();
            $table->string('hazard_code')->nullable();
            $table->string('hazard_statement')->nullable();
            $table->longText('description')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('hazards');
    }
}

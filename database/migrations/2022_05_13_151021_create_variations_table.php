<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('experiment_id')->default(0);
            $table->json('process_flow_table')->nullable();
            $table->json('process_flow_chart')->nullable();
            $table->json('unit_specification')->nullable();
            $table->json('models')->nullable();
            $table->json('dataset')->nullable();
            $table->json('datamodel')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('description')->nullable();
            $table->string('note_urls')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->enum('prev_status', ['active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('variations');
    }
}

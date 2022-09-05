<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->json('association')->nullable();
            $table->json('recommendations')->nullable();
            $table->json('list_of_models')->nullable();
            $table->json('assumptions')->nullable();
            $table->json('files')->nullable();
            $table->json('tags')->nullable();
            $table->integer('process_experiment_id')->default(0);
            $table->integer('model_type')->default(0);
            $table->integer('configuration')->default(0);
            $table->integer('flag')->default(0);
            $table->longText('description')->nullable();
            $table->enum('status', ['requested', 'under_process', 'processed'])->default('requested');
            $table->enum('operation_status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('model_details');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 500);
            $table->integer('tenant_id')->default(0);
            $table->string('description', 500)->nullable();
            $table->string('file_name', 500);
            $table->json('data_request')->nullable();
            $table->enum('status', ['Draft', 'Requested', 'Under Review', 'Published'])->default('Draft');
            $table->integer('requested_by')->default(0);
            $table->integer('requested_by_tenant')->default(0);
            $table->date('requested_date')->nullable();
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
        Schema::dropIfExists('data_requests');
    }
}

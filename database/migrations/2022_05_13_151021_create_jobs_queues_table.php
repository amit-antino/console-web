<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_queues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jobs', 45)->nullable();
            $table->json('queue_data')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('created_by')->nullable()->default(0);
            $table->string('deleted_at', 45)->nullable()->default('0');
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
        Schema::dropIfExists('jobs_queues');
    }
}

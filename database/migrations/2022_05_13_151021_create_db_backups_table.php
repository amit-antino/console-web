<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_backups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tenant_id')->default(0);
            $table->string('minute')->nullable();
            $table->string('hour')->nullable();
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('day_week')->nullable();
            $table->string('backup_period')->nullable();
            $table->enum('status', ['active', 'inactive', 'success', 'failed'])->default('active');
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
        Schema::dropIfExists('db_backups');
    }
}

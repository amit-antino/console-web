<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimInpTemplateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_inp_template_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('template_id', 500);
			$table->integer('tenant_id',)->default('0');
            $table->string('template_name', 500)->nullable();
            $table->string('variation_id', 500);
            $table->string('type', 500)->nullable();
            $table->string('excel_file', 500);
            $table->integer('status')->default(0);
            $table->string('entry_by', 500)->nullable();
            $table->string('ip_add', 500)->nullable();
            $table->string('created_at', 500)->default('0');
            $table->string('updated_at', 500)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sim_inp_template_uploads');
    }
}

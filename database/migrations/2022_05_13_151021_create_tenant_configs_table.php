<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id');
            $table->bigInteger('number_of_users')->default(0);
            $table->enum('two_factor_auth', ['true', 'false'])->default('false');
            $table->json('menu_group')->nullable();
            $table->json('location')->nullable();
            $table->json('user_group')->nullable();
            $table->json('designation')->nullable();
            $table->json('calc_server')->nullable();
            $table->json('user_permission')->nullable();
            $table->json('user_settings')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('tenant_configs');
    }
}

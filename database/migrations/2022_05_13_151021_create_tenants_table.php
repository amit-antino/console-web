<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('type')->nullable();
            $table->integer('plan_type')->nullable();
            $table->json('account_details')->nullable();
            $table->json('billing_information')->nullable();
            $table->longText('description')->nullable();
            $table->json('images')->nullable();
            $table->json('guide_document')->nullable();
            $table->longText('note')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->enum('ldap_auth', ['on', 'off'])->default('off');
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
        Schema::dropIfExists('tenants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegulatoryListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulatory_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tenant_id')->default(0);
            $table->string('list_name')->nullable();
            $table->integer('classification_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('color_code')->nullable();
            $table->enum('display_hazard_code', ['1', '0'])->default('0');
            $table->string('region')->nullable();
            $table->string('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('compilation')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->string('match_type')->nullable();
            $table->string('csv_name')->nullable();
            $table->string('hazard_code')->nullable();
            $table->integer('no_of_list')->nullable();
            $table->string('source_file')->nullable();
            $table->string('converted_file')->nullable();
            $table->string('hover_msg')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description')->nullable();
            $table->json('field_of_display')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
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
        Schema::dropIfExists('regulatory_lists');
    }
}

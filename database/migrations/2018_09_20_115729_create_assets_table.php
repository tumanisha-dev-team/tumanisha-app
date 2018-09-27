<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id')->nullable();
            $table->string('registration_no')->unique();
            $table->string('engine_no')->unique();
            $table->string('log_book_no')->nullable();
            $table->string('chassis_no')->unique();
            $table->string('model');
            $table->date('date_purchased');
            $table->string('color');
            $table->integer('asset_type');
            $table->string('make');
            $table->string('invoice_no')->nullable();
            $table->string('engine_body');
            $table->string('dealer')->nullable();
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
        Schema::dropIfExists('assets');
    }
}

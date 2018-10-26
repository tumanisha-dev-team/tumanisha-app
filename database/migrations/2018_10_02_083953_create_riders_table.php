<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('national_id_no')->unique();
            $table->string('license_no')->unique();
            $table->string('kra_pin')->nullable();
            $table->string('nhif_no')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('nationality');
            $table->integer('religion');
            $table->string('primary_phone_number')->unique();
            $table->string('secondary_phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('college_high_school')->nullable();
            $table->string('primary_school')->nullable();
            $table->string('height');
            $table->string('eye_color');
            $table->string('hair_color');
            $table->longText('photo_url')->nullable();
            $table->longText('id_url')->nullable();
            $table->longText('license_url')->nullable();
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
        Schema::dropIfExists('riders');
    }
}

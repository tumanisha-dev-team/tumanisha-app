<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('riders_id');
            $table->string('company_name');
            $table->string('role');
            $table->timestamps();

            $table->foreign('riders_id')
                    ->references('id')->on('riders')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rider_experiences');
    }
}

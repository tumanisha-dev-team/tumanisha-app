<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderExperienceRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_experience_referees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rider_experiences_id');
            $table->string('referee_name');
            $table->string('referee_contact');
            $table->string('referee_email')->nullable();
            $table->timestamps();

            $table->foreign('rider_experiences_id')
                    ->references('id')->on('rider_experiences')
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
        Schema::dropIfExists('rider_experience_referees');
    }
}

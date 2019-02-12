<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderDeactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_deactivations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rider_id');
            $table->date('from');
            $table->date('to')->nullable();
            $table->text('reason')->nullable();
            $table->integer('deactivated_by');
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
        Schema::dropIfExists('rider_deactivations');
    }
}

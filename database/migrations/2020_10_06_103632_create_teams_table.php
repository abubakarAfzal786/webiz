<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}

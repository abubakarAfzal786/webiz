<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingAttributesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_attributes_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedSmallInteger('quantity');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('attribute_id')->references('id')->on('room_attributes')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_attributes_pivot');
    }
}

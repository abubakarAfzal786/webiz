<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReviewsAddBookingId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table){
            $table->unsignedBigInteger('booking_id')->nullable();

            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table){
            $table->dropForeign('reviews_booking_id_foreign');
            $table->dropColumn('booking_id');
        });
    }
}

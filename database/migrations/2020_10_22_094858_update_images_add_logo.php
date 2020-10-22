<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImagesAddLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->boolean('is_logo')->default(false);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('logo_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('is_logo');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('logo_id');
        });
    }
}

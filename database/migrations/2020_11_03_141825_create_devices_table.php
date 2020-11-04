<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('device_id');
            $table->string('description')->nullable();
            $table->integer('state')->default(0);
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('room_id');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('device_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('room_id')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}

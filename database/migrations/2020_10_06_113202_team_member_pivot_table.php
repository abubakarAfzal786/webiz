<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeamMemberPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('joined')->default(false);

            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_member_pivot');
    }
}

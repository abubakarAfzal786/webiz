<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->smallInteger('type')->default(Transaction::TYPE_ROOM);
            $table->decimal('credit', 15, 2);
            $table->decimal('price', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('transactions');
    }
}

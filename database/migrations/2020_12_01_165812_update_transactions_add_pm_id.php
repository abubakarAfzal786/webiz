<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsAddPmId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->smallInteger('status')->default(Transaction::STATUS_PENDING);
            $table->unsignedBigInteger('method_id')->nullable()->after('booking_id');
            $table->foreign('method_id')->references('id')->on('payment_methods')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropForeign('transactions_method_id_foreign');
            $table->dropColumn('method_id');
        });
    }
}

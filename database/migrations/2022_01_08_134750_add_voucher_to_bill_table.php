<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoucherToBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill', function (Blueprint $table) {
            $table->bigInteger('voucher_id')->nullable()->unsigned();
            $table->index('voucher_id')->nullable();
            $table->foreign('voucher_id')->nullable()->references('id')->on('voucher')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill', function (Blueprint $table) {
            $table->dropForeign('bill_voucher_id_foreign');
            $table->dropColumn('voucher_id');
        });
    }
}

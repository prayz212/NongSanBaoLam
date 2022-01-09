<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFkVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher', function (Blueprint $table) {
            $table->dropForeign('voucher_bill_id_foreign');
            $table->dropColumn('bill_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher', function (Blueprint $table) {
            // $table->bigInteger('bill_id')->unsigned()->index();
            // $table->foreign('bill_id')->references('id')->on('bill')->onDelete('cascade');
        });
    }
}

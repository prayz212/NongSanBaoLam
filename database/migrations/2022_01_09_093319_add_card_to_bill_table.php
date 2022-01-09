<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardToBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill', function (Blueprint $table) {
            $table->bigInteger('card_id')->nullable()->unsigned();
            $table->index('card_id')->nullable();
            $table->foreign('card_id')->nullable()->references('id')->on('card')->onDelete('cascade');
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
            $table->dropForeign('bill_card_id_foreign');
            $table->dropColumn('card_id');
        });
    }
}

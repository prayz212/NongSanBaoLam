<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->bigInteger('bill_id')->unsigned()->index();
            $table->foreign('bill_id')->references('id')->on('bill')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('unit_price');
            $table->integer('quantity');
            $keys = array('bill_id', 'product_id');
            $table->primary($keys);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_detail');
    }
}

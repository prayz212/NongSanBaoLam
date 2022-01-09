<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('notes');
            $table->bigInteger('totalPrice');
            $table->bigInteger('totalDiscount');
            $table->bigInteger('shippingCost');
            $table->bigInteger('totalPay');
            $table->string('method');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('delivery_at')->nullable();
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
        Schema::dropIfExists('bill');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('discount');
            $table->boolean('is_used')->default(false);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->bigInteger('bill_id')->unsigned()->index();
            $table->foreign('bill_id')->references('id')->on('bill')->onDelete('cascade');
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
        Schema::dropIfExists('voucher');
    }
}

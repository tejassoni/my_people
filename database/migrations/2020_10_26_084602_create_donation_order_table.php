<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 255)->nullable()->comment('unique order_id e.g ORDS99454825');
            $table->integer('user_id')->nullable()->comment('login user id');
            $table->integer('subscription_id')->nullable()->comment('subscription or plan id');
            $table->integer('payment_id')->nullable()->comment('unique payment id');
            $table->string('payment_request_id', 255)->nullable()->comment('unique payment request id');
            $table->string('payment_method', 100)->nullable()->comment('payment gateway name');
            $table->string('payment_mode', 100)->nullable()->comment('netbanking, cash or upi');
            $table->string('payment_currency', 50)->nullable()->comment('payment currency');
            $table->string('bank_name', 100)->nullable()->comment('payment bank name');
            $table->integer('qty')->nullable()->comment('subscription or product quantity');
            $table->integer('total_amount')->nullable()->comment('payment total amount');
            $table->string('payment_status', 100)->nullable()->comment('pending, completed, fail');
            $table->char('payment_received', 3)->nullable()->comment('yes, no');
            $table->dateTime('payment_date', 0)->nullable()->comment('YYYY-MM-DD HH:MM:SS');
            $table->text('cart_data')->nullable()->comment('json response payment data');
            $table->tinyInteger('status')->default(0)->comment('0, 1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donation_order');
    }
}

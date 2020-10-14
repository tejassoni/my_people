<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->string('payment_request_id', 255)->nullable();
            $table->string('payment_method', 100)->nullable();
            $table->string('payment_mode', 100)->nullable();
            $table->string('payment_currency', 50)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('total_amount')->nullable();
            $table->string('payment_status', 100)->nullable();
            $table->char('payment_received', 3)->nullable();
            $table->text('cart_data')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}

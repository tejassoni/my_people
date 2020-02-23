<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_master', function (Blueprint $table) {
            $table->bigIncrements('sub_id');
            $table->string('sub_name', 100)->nullable();
            $table->string('sub_alias', 50)->nullable();
            $table->text('sub_description')->nullable();
            $table->integer('plan_id')->nullable();            
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
        Schema::dropIfExists('subscription_master');
    }
}

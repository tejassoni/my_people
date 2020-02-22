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
            $table->string('sub_name', 100);
            $table->string('sub_alias', 50);
            $table->text('sub_description');
            $table->integer('plan_id');
            $table->enum('trail_pack', ['active', 'in-active']);
            $table->enum('status', ['active', 'in-active']);
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

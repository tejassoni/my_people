<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->nullable(true);
            $table->string('email', 200)->nullable(true);
            $table->string('mobile', 50)->nullable(true);
            $table->double('amount', 16, 2)->default(0);
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('donation');
    }
}

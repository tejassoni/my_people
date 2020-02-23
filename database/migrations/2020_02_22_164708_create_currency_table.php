<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_master', function (Blueprint $table) {
            $table->bigIncrements('currency_id');
            $table->string('country_name', 100)->nullable(true);
            $table->string('currency_name', 100)->nullable(true);
            $table->string('code', 20)->nullable(true);
            $table->string('symbol', 20)->nullable(true);
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
        Schema::dropIfExists('currency_master');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_master', function (Blueprint $table) {
            $table->bigIncrements('discount_id');
            $table->string('discount_name', 200)->nullable(true);
            $table->text('discount_description')->nullable(true);
            $table->string('discount_type', 200)->nullable(true);
            $table->double('amount', 16, 2)->default(0);
            $table->tinyInteger('is_discount_validity')->default(0);
            $table->date('start_date')->nullable(true);
            $table->date('end_date')->nullable(true);
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
        Schema::dropIfExists('discount_master');
    }
}

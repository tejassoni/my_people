<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_master', function (Blueprint $table) {
            $table->bigIncrements('plan_id');
            $table->string('plan_name', 100)->nullable();
            $table->string('plan_alias', 50)->nullable();
            $table->text('plan_description')->nullable();
            $table->double('plan_amount', 16, 2)->default(0);
            $table->integer('discount_id')->default(0);
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
        Schema::dropIfExists('plan_master');
    }
}

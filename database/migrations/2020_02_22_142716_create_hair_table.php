<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hair_master', function (Blueprint $table) {
            $table->bigIncrements('hair_id');
            $table->string('hair_style_name', 255)->nullable();
            $table->string('hair_color', 255)->nullable();
            $table->text('hair_description')->nullable();
            $table->string('hair_img', 255)->nullable();
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
        Schema::dropIfExists('hair_master');
    }
}

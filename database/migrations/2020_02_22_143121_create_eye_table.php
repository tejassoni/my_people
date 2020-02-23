<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEyeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eye_master', function (Blueprint $table) {
            $table->bigIncrements('eye_id');
            $table->string('eye_name', 255)->nullable();
            $table->string('eye_color', 255)->nullable();            
            $table->text('eye_description')->nullable();      
            $table->string('eye_img', 255)->nullable();                  
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
        Schema::dropIfExists('eye_master');
    }
}

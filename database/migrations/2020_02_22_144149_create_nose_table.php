<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nose_master', function (Blueprint $table) {
            $table->bigIncrements('nose_id');
            $table->string('nose_name', 255)->nullable();
            $table->string('nose_color', 255)->nullable();            
            $table->text('nose_description')->nullable();      
            $table->string('nose_img', 255)->nullable();                  
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
        Schema::dropIfExists('nose_master');
    }
}

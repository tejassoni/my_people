<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ear_master', function (Blueprint $table) {
            $table->bigIncrements('ear_id');
            $table->string('ear_name', 255)->nullable();
            $table->string('ear_color', 255)->nullable();            
            $table->text('ear_description')->nullable();      
            $table->string('ear_img', 255)->nullable();                  
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
        Schema::dropIfExists('ear_master');
    }
}

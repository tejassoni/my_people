<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaw_master', function (Blueprint $table) {
            $table->bigIncrements('jaw_id');
            $table->string('jaw_name', 255)->nullable();
            $table->string('jaw_color', 255)->nullable();            
            $table->text('jaw_description')->nullable();      
            $table->string('jaw_img', 255)->nullable();                  
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
        Schema::dropIfExists('jaw_master');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skin_master', function (Blueprint $table) {
            $table->bigIncrements('skin_id');
            $table->string('skin_name', 255)->nullable();
            $table->string('skin_color', 255)->nullable();            
            $table->text('skin_description')->nullable();      
            $table->string('skin_img', 255)->nullable();                  
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
        Schema::dropIfExists('skin_master');
    }
}

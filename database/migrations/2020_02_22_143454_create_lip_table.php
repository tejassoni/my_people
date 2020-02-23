<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lip_master', function (Blueprint $table) {
            $table->bigIncrements('lip_id')->nullable();
            $table->string('lip_name', 255)->nullable();
            $table->string('lip_color', 255)->nullable();            
            $table->text('lip_description')->nullable();      
            $table->string('lip_img', 255)->nullable();                  
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
        Schema::dropIfExists('lip_master');
    }
}

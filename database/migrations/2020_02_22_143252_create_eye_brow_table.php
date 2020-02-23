<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEyeBrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eye_brow_master', function (Blueprint $table) {
            $table->bigIncrements('eye_brow_id');
            $table->string('eye_brow_name', 255)->nullable();
            $table->string('eye_brow_color', 255)->nullable();            
            $table->text('eye_brow_description')->nullable();      
            $table->string('eye_brow_img', 255)->nullable();                  
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
        Schema::dropIfExists('eye_brow_master');
    }
}

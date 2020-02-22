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
            $table->string('eye_name', 255);
            $table->string('eye_color', 255);            
            $table->text('eye_description');      
            $table->string('eye_img', 255);                  
            $table->enum('status', ['active', 'in-active']);
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

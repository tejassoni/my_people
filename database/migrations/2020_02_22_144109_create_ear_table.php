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
            $table->string('ear_name', 255);
            $table->string('ear_color', 255);            
            $table->text('ear_description');      
            $table->string('ear_img', 255);                  
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
        Schema::dropIfExists('ear_master');
    }
}

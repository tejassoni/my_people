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
            $table->string('jaw_name', 255);
            $table->string('jaw_color', 255);            
            $table->text('jaw_description');      
            $table->string('jaw_img', 255);                  
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
        Schema::dropIfExists('jaw_master');
    }
}

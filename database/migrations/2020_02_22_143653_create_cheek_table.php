<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheek_master', function (Blueprint $table) {
            $table->bigIncrements('cheek_id');
            $table->string('cheek_name', 255);
            $table->string('cheek_color', 255);            
            $table->text('cheek_description');      
            $table->string('cheek_img', 255);                  
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
        Schema::dropIfExists('cheek_master');
    }
}

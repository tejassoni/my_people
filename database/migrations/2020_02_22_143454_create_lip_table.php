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
            $table->bigIncrements('lip_id');
            $table->string('lip_name', 255);
            $table->string('lip_color', 255);            
            $table->text('lip_description');      
            $table->string('lip_img', 255);                  
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
        Schema::dropIfExists('lip_master');
    }
}

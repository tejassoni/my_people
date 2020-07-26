<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFindPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('find_person', function (Blueprint $table) {
            $table->bigIncrements('find_id');
            $table->integer('missing_id')->nullable(true);
            $table->string('find_person_img', 255)->nullable();
            $table->text('description')->nullable(true);
            $table->string('approval_status', 20)->nullable(true);
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
        Schema::dropIfExists('find_person');
    }
}

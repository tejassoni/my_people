<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissingPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_person', function (Blueprint $table) {
            $table->bigIncrements('missing_id');
            $table->string('missing_person_img', 255)->nullable();
            $table->string('f_name', 50)->nullable(true);
            $table->string('m_name', 50)->nullable(true);
            $table->string('l_name', 50)->nullable(true);
            $table->date('birth_date')->nullable(true);
            $table->integer('age')->nullable(true);
            $table->text('address')->nullable(true);
            $table->integer('country_id')->nullable(true); // Foriegn Key table country_master
            $table->integer('state_id')->nullable(true); // Foriegn Key table state_master
            $table->integer('city_id')->nullable(true); // Foriegn Key table city_master
            $table->string('pincode')->nullable(true);
            $table->date('missed_date')->nullable(true);
            $table->integer('user_id')->nullable(true); // Foriegn Key table user_master
            $table->integer('hair_id')->nullable(true); // Foriegn Key table hair_master
            $table->integer('eye_id')->nullable(true); // Foriegn Key table eye_master
            $table->integer('eye_brow_id')->nullable(true); // Foriegn Key table eye_brow_master
            $table->integer('lip_id')->nullable(true); // Foriegn Key table lip_master
            $table->integer('jaw_id')->nullable(true); // Foriegn Key table jaw_master
            $table->integer('skin_id')->nullable(true); // Foriegn Key table skin_master
            $table->integer('ear_id')->nullable(true); // Foriegn Key table ear_master
            $table->integer('nose_id')->nullable(true); // Foriegn Key table nose_master
            $table->text('remark')->nullable(true);
            $table->text('cloth_description')->nullable(true);
            $table->integer('currency_id')->nullable(true); // Foriegn Key table currency_master
            $table->string('amount')->nullable(true);
            $table->tinyInteger('is_found')->default(0);
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
        Schema::dropIfExists('missing_person');
    }
}

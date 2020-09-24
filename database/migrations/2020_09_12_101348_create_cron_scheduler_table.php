<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronSchedulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_scheduler', function (Blueprint $table) {
            $table->bigIncrements('cron_id');
            $table->string('cron_name', 255)->nullable();
            $table->string('cron_alias', 50)->nullable()->comment('slug');
            $table->text('cron2_description')->nullable();
            $table->longText('cron_data')->nullable()->comment('format: json, xml');
            $table->string('cron_time_duration', 50)->nullable()->comment('Eg. 06:15-am, 12:00-pm');
            $table->string('cron_interval', 50)->nullable()->comment('minute, hour, week, month, year');
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
        Schema::dropIfExists('cron_scheduler');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrayerTimings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prayer_timings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('first_azan');
            $table->time('daybreak');
            $table->time('sunrise');
            $table->time('noon');
            $table->time('afternoon');
            $table->time('sunset');
            $table->time('evening');
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
        Schema::dropIfExists('prayer_timings');
    }
}

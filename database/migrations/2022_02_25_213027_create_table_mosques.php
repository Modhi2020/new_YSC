<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMosques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->foreignId('muzzin_id')->nullable()->references('id')->on('preachers')->onDelete('cascade');
            $table->foreignId('imam_id')->nullable()->references('id')->on('preachers')->onDelete('cascade');
            $table->foreignId('preacher_id')->nullable()->references('id')->on('preachers')->onDelete('cascade');
            $table->integer('quran')->default(0);
            $table->integer('library')->default(0);
            $table->tinyInteger('furnishings')->default(2);
            $table->tinyInteger('audio_equipment')->default(2);
            $table->tinyInteger('power_source')->default(2);
            $table->foreignId('logistic_id')->nullable()->references('id')->on('logistic_supports')->onDelete('cascade');
            $table->text('contents')->nullable();
            $table->text('address')->nullable();
            $table->text('mylocation')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->foreignId('region_id')->nullable()->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('directorate_id')->nullable()->references('id')->on('directorates')->onDelete('cascade');
            $table->tinyInteger('ready')->default(2);
            $table->boolean('select')->default(1);
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
        Schema::dropIfExists('mosques');
    }
}

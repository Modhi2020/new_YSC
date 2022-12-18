<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aboutus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('whowe')->nullable();
            $table->text('whyus')->nullable();
            $table->text('msg')->nullable();
            $table->text('vision')->nullable();
            $table->text('teamdesc')->nullable();
            $table->tinyInteger('ready')->default(2);
            $table->string('whoweimg')->nullable();
            $table->string('whyusimg')->nullable();
            // $table->string('visionimg')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('aboutus');
    }
}
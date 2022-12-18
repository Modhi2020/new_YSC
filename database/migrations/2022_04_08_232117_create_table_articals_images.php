<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArticalsImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articals_images', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('page')->nullable();
            $table->bigInteger('imageable_id');
            $table->bigInteger('subart_id')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->string('path')->nullable();
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
        Schema::dropIfExists('articals_images');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMylikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mylikes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('likeable_id');
            $table->integer('likes');
            $table->string('likeable_type');
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
        Schema::dropIfExists('mylikes');
    }
}

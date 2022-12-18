<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMysessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mysessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('details');
            $table->date('start_time')->nullable()->default(date('Y-m-d'));
            $table->date('end_time')->nullable()->default(date('Y-m-d'));
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->string('url_link')->nullable();
            $table->tinyInteger('ready')->default(2);
            $table->tinyInteger('type')->default(1);
            $table->boolean('select')->default(1);
            $table->foreignId('instructor_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('beneficiary_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('mysessions');
    }
}

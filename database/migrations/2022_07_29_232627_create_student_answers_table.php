<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->string('answers');
            $table->string('type')->nullable();
            $table->float('score')->default(0.00);
            $table->boolean('status')->default(0);
            $table->boolean('select')->default(1);
            $table->foreignId('student_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('survey_id')->nullable()->references('id')->on('surveys')->onDelete('cascade');
            $table->foreignId('opportunity_id')->nullable()->references('id')->on('opportunities')->onDelete('cascade');
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
        Schema::dropIfExists('student_answers');
    }
}

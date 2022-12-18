<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckboxQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkbox_questions', function (Blueprint $table) {
            $table->id();
            $table->text('questions');
            $table->string('type')->default('checkbox_questions');
            $table->text('slug')->nullable();
            $table->text('first_answer')->nullable();
            $table->text('second_answer')->nullable();
            $table->text('third_answer')->nullable();
            $table->text('fourth_answer')->nullable();
            $table->text('correct_answer')->nullable();
            $table->integer('degree')->nullable();
            $table->tinyInteger('ready')->default(2);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('checkbox_questions');
    }
}

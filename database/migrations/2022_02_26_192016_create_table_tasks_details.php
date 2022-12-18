<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTasksDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->references('id')->on('tasks_masters')->onDelete('cascade');
            $table->foreignId('commissioner_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->date('beginning')->nullable()->default(date('Y-m-d'));
            $table->date('deadline')->nullable()->default(date('Y-m-d'));
            $table->tinyInteger('stage')->default(1);
            $table->text('com_results')->nullable();
            $table->tinyInteger('repeat_id')->default(3);
            $table->tinyInteger('agree')->default(2);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('tasks_details');
    }
}

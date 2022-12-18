<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTasksMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_masters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->date('date');
            $table->tinyInteger('type')->default(3);
            $table->tinyInteger('state')->default(1);
            $table->tinyInteger('degree')->default(3);
            $table->foreignId('supervisor_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->text('results')->nullable();
            $table->string('url_link')->nullable();
            $table->tinyInteger('agree')->default(1);
            $table->integer('num_recovery')->default(1);
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
        Schema::dropIfExists('tasks_masters');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncentivesSanctionsDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives_sanctions_dets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inc_san_id')->nullable()->references('id')->on('incentives_sanctions_mas')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->references('id')->on('tasks_masters')->onDelete('cascade');
            $table->foreignId('incentive_id')->nullable()->references('id')->on('incentives')->onDelete('cascade');
            $table->foreignId('punishment_id')->nullable()->references('id')->on('punishments')->onDelete('cascade');
            $table->double('price', 8, 2);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('incentives_sanctions_dets');
    }
}

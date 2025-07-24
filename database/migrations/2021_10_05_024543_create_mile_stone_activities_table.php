<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMileStoneActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mile_stone_activities', function (Blueprint $table) {
            $table->id();
            $table->string('Activity');
            $table->integer('BeforeStart')->nullable();
            $table->integer('AfterStart')->nullable();
            $table->integer('BeforeFinish')->nullable();
            $table->integer('AfterFinish')->nullable();
            $table->string('Document')->nullable();
            $table->string('Link')->nullable();
            $table->string('Folder')->nullable();
            $table->foreignId('Responsible')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('Dynamic');
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
        Schema::dropIfExists('mile_stone_activities');
    }
}

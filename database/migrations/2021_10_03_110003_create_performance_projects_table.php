<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('SafetyHealth')->nullable();
            $table->integer('Quality')->nullable();
            $table->integer('Duration')->nullable();
            $table->float('ManHour')->nullable();
            $table->float('WastingTime')->nullable();
            $table->float('ManHourRatio')->nullable();
            $table->integer('MileStone')->nullable();
            $table->integer('ISO')->nullable();
            $table->float('KPI')->nullable();
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
        Schema::dropIfExists('performance_projects');
    }
}

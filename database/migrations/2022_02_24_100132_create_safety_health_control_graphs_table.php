<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafetyHealthControlGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safety_health_control_graphs', function (Blueprint $table) {
            $table->id();
            $table->date('Month');
            $table->float('T_TIFR');
            $table->integer('Incident');
            $table->integer('Man');
            $table->integer('Day');
            $table->float('T_DI');
            $table->integer('DI');
            $table->integer('LossDay');
            $table->float('T_TotalLoss');
            $table->float('TotalLoss');
            $table->float('T_Examination');
            $table->integer('Examination');
            $table->integer('T_Disease');
            $table->integer('Disease');
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
        Schema::dropIfExists('safety_health_control_graphs');
    }
}

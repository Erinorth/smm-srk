<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolCatagoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_catagories', function (Blueprint $table) {
            $table->id();
            $table->string('CatagoryName');
            $table->string('RangeCapacity')->nullable();
            $table->string('Unit');
            $table->string('Type')->nullable();
            $table->string('MeasuringTool');
            $table->integer('Min');
            $table->integer('Max');
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
        Schema::dropIfExists('tool_catagories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolPMIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_p_m_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('Activity');
            $table->integer('Interval');
            $table->string('Remark')->nullable();
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
        Schema::dropIfExists('tool_p_m_intervals');
    }
}

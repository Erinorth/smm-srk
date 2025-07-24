<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolPMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_p_m_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_p_m_interval_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('PMDate');
            $table->string('Operator');
            $table->decimal('Cost');
            $table->string('Result');
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
        Schema::dropIfExists('tool_p_m_s');
    }
}

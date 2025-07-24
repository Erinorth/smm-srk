<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWFHWFAAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_f_h_w_f_a_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('date_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Assignee')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->float('Day');
            $table->integer('Point');
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
        Schema::dropIfExists('w_f_h_w_f_a_assignments');
    }
}

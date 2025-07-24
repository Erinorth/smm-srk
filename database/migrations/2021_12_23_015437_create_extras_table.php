<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->id();
            $table->string('WorkingDate');
            $table->foreignId('p_m_order_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('job_position_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('Normal');
            $table->time('OTfrom');
            $table->time('OTto');
            $table->float('OT1');
            $table->float('OT15');
            $table->float('OT2');
            $table->float('OT3');
            $table->string('Remark')->nullable();
            $table->foreignId('extra_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('extras');
    }
}

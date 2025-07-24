<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityControlGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_control_graphs', function (Blueprint $table) {
            $table->id();
            $table->float('T_Duration');
            $table->integer('P_Duration');
            $table->integer('A_Duration');
            $table->integer('T_Rework');
            $table->integer('Rework');
            $table->integer('Claim');
            $table->float('CostValue');
            $table->integer('P_Complain');
            $table->integer('G_Complain');
            $table->integer('A_Complain');
            $table->integer('R_Complain');
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
        Schema::dropIfExists('quality_control_graphs');
    }
}

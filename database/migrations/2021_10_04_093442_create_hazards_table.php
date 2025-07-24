<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHazardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hazards', function (Blueprint $table) {
            $table->id();
            $table->string('HazardName');
            $table->string('Type');
            $table->string('ManPower');
            $table->string('Contact');
            $table->string('Procedure');
            $table->string('Training');
            $table->string('PPE');
            $table->string('SafetyEquipment');
            $table->string('Verification');
            $table->string('SafetySign');
            $table->float('Opportunity');
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
        Schema::dropIfExists('hazards');
    }
}

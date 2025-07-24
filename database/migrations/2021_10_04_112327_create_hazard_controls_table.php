<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHazardControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hazard_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hazard_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('KindofHazard');
            $table->string('Effect');
            $table->string('Severity');
            $table->string('HazardControl')->nullable();
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
        Schema::dropIfExists('hazard_controls');
    }
}

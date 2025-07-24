<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOfRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_of_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factor_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('TypeofRisk');
            $table->string('Effect');
            $table->integer('EffectValue');
            $table->string('Measure');
            $table->string('Followup');
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
        Schema::dropIfExists('type_of_risks');
    }
}

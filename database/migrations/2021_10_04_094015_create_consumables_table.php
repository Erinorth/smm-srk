<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('ConsumableCode');
            $table->string('PurchaseCode');
            $table->string('ConsumableName');
            $table->string('Detail')->nullable();
            $table->string('Unit');
            $table->double('Weight');
            $table->float('Cost');
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
        Schema::dropIfExists('consumables');
    }
}

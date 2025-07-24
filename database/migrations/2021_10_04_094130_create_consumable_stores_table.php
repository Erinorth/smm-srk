<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumable_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('InOut');
            $table->integer('Quantity');
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
        Schema::dropIfExists('consumable_stores');
    }
}

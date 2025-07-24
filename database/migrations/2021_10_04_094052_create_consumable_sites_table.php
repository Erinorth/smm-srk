<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumable_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p_m_order_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('consumable_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('Pick');
            $table->string('Confirmed');
            $table->integer('Return');
            $table->string('Packing')->nullable();
            $table->string('Group')->nullable();
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
        Schema::dropIfExists('consumable_sites');
    }
}

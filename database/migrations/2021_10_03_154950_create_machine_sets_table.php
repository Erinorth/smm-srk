<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('machine_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('Remark')->nullable();
            $table->string('SerialNumber')->nullable();
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
        Schema::dropIfExists('machine_sets');
    }
}

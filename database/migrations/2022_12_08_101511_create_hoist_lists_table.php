<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoistListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoist_lists', function (Blueprint $table) {
            $table->id();
            $table->string('Customer');
            $table->string('Brand')->nullable();
            $table->float('Capacity');
            $table->string('Model')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->string('LocalCode')->nullable();
            $table->string('DurableSupplieCode')->nullable();
            $table->string('AssetToolCode')->nullable();
            $table->date('RegisterDate')->nullable();
            $table->float('StandardP')->nullable();
            $table->float('StandardD')->nullable();
            $table->float('Standard10Link')->nullable();
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
        Schema::dropIfExists('hoist_lists');
    }
}

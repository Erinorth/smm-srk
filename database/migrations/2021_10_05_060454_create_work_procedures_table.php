<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->nullable()->constrained();
            $table->foreignId('item_id')->nullable()->constrained();
            $table->integer('Order');
            $table->integer('Order2');
            $table->string('Procedure');
            $table->text('ControlledPoint')->nullable();
            $table->string('Class');
            $table->integer('Man');
            $table->float('Hour');
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
        Schema::dropIfExists('work_procedures');
    }
}

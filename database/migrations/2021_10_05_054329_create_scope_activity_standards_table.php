<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScopeActivityStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scope_activity_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scope_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('Order');
            $table->string('ActivityName');
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
        Schema::dropIfExists('scope_activity_standards');
    }
}

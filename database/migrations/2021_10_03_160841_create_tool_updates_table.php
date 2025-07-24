<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_catagory_site_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tool_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('Status');
            $table->string('Remark')->nullable();
            $table->string('Packing')->nullable();
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
        Schema::dropIfExists('tool_updates');
    }
}

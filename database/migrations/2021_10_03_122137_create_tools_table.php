<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_catagory_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('Brand')->nullable();
            $table->string('Model')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->string('LocalCode')->nullable();
            $table->string('DurableSupplieCode')->nullable();
            $table->string('AssetToolCode')->nullable();
            $table->float('Weight');
            $table->decimal('Price');
            $table->integer('LifeTime');
            $table->date('RegisterDate');
            $table->foreignId('Responsible')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('Accepted')->nullable();
            $table->string('AcceptedPath')->nullable();
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
        Schema::dropIfExists('tools');
    }
}

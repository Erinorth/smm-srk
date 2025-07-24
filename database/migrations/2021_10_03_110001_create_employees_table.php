<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('no action')->onDelete('no action');
            $table->string('WorkID');
            $table->string('ThaiName');
            $table->string('EnglishName')->nullable();
            $table->string('Position');
            $table->string('EGATEmail')->nullable();
            $table->string('department_id');
            $table->string('Admin');
            $table->string('Telephone');
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
        Schema::dropIfExists('employees');
    }
}

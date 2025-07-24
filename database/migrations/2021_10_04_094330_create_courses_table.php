<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('CourseName');
            $table->string('Type');
            $table->foreignId('ForDepartment')->constrained('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ForPosition')->constrained('job_positions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('OnSite');
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
        Schema::dropIfExists('courses');
    }
}

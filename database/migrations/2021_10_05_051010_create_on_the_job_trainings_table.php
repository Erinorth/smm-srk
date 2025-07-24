<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnTheJobTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_the_job_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('job_position_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->date('EvaluationDate')->nullable();
            $table->string('Result')->nullable();
            $table->foreignId('Recorder')->nullable()->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Approver')->nullable()->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->date('ApprovedDate')->nullable();
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
        Schema::dropIfExists('on_the_job_trainings');
    }
}

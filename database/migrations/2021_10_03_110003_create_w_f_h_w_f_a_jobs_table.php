<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWFHWFAJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_f_h_w_f_a_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('w_f_h_w_f_a_assignments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('routine_job_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->mediumText('Detail');
            $table->float('TargetPoint');
            $table->float('AcceptPoint')->nullable();
            $table->foreignId('Assignor')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('w_f_h_w_f_a_jobs');
    }
}

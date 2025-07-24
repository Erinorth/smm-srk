<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('CompanyName');
            $table->string('WorkingArea');
            $table->string('JobName');
            $table->integer('Amount');
            $table->date('PlanedDate');
            $table->string('Reference');
            $table->string('Supervisor');
            $table->string('Applicant');
            $table->string('Attachment')->nullable();
            $table->string('AttachmentPath')->nullable();
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
        Schema::dropIfExists('drones');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('ProjectName');
            $table->foreignId('project_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('StartDate');
            $table->date('FinishDate');
            $table->foreignId('SiteEngineer')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('AreaManager')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('Status');
            $table->string('color');
            $table->string('show');
            $table->integer('Supervisor');
            $table->integer('Foreman');
            $table->integer('Skill');
            $table->string('KeyDate')->nullable();
            $table->string('KeyDatePath')->nullable();
            $table->string('DailyReport')->nullable();
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
        Schema::dropIfExists('projects');
    }
}

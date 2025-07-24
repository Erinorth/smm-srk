<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('Day');
            $table->float('SafetyHealth');
            $table->string('SafetyHealthRemark')->nullable();
            $table->float('Quality');
            $table->string('QualityRemark')->nullable();
            $table->float('TeamWork');
            $table->string('TeamWorkRemark')->nullable();
            $table->float('Planing');
            $table->string('PlaningRemark')->nullable();
            $table->float('MoralGoodGovernance');
            $table->string('MoralGoodGovernanceRemark')->nullable();
            $table->float('Professional');
            $table->string('ProfessionalRemark')->nullable();
            $table->float('Innovation');
            $table->string('InnovationRemark')->nullable();
            $table->float('Digital');
            $table->string('DigitalRemark')->nullable();
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
        Schema::dropIfExists('performance_employees');
    }
}

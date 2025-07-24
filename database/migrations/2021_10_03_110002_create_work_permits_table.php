<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('Date');
            $table->tinyinteger('HotWork')->nullable();
            $table->tinyinteger('ConfinedSpace')->nullable();
            $table->tinyinteger('Chemical')->nullable();
            $table->tinyinteger('Lifting')->nullable();
            $table->tinyinteger('Scaffloding')->nullable();
            $table->tinyinteger('Electrical')->nullable();
            $table->tinyinteger('HighVoltage')->nullable();
            $table->tinyinteger('Drilling')->nullable();
            $table->tinyinteger('Radio')->nullable();
            $table->tinyinteger('Diving')->nullable();
            $table->string('Other')->nullable();
            $table->foreignId('Requester')->constrained('employees');
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
        Schema::dropIfExists('work_permits');
    }
}

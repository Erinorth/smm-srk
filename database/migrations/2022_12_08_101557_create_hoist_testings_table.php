<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoistTestingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoist_testings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('hoist_list_id')->nullable()->unsigned();
            $table->integer('tool_id')->nullable()->unsigned();
            $table->date('TestDate');
            $table->string('TopHook');
            $table->string('BottomHook');
            $table->string('SafetyLatch');
            $table->string('Condition');
            $table->string('Pin');
            $table->string('Testing');
            $table->string('Remark')->nullable();
            $table->float('LoadP');
            $table->float('LoadD');
            $table->float('Load10Link');
            $table->string('LoadTesting');
            $table->string('Twist');
            $table->float('HookTop');
            $table->float('HookBottom');
            $table->string('Result');
            $table->string('Note')->nullable();
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
        Schema::dropIfExists('hoist_testings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('Report');
            $table->text('Cause');
            $table->float('Value');
            $table->text('Guideline')->nullable();
            $table->text('Operation')->nullable();
            $table->string('Operator')->nullable();
            $table->text('Result')->nullable();
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
        Schema::dropIfExists('tool_breakdowns');
    }
}

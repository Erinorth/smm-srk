<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolCalibratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_calibrates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('CalibrateDate');
            $table->string('Calibrator');
            $table->string('Result');
            $table->string('Certificate');
            $table->string('Accuracy');
            $table->string('AcceptError');
            $table->date('ExpireDate');
            $table->decimal('Cost');
            $table->string('Remark')->nullable();
            $table->foreignId('Responsible')->constrained('employees')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tool_calibrates');
    }
}

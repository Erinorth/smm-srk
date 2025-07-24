<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCraneCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crane_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_set_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('TestDate');
            $table->text('Result');
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
        Schema::dropIfExists('crane_certificates');
    }
}

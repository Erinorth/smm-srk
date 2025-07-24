<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_types', function (Blueprint $table) {
            $table->id();
            $table->string('ActivityType')->nullable();
            $table->string('MainType')->nullable();
            $table->string('SubType');
            $table->string('ToolName');
            $table->string('Remark')->nullable();
            $table->timestamps();
        });

        Schema::table('tool_catagories', function (Blueprint $table) {
            $table->foreignId('tool_type_id')->after('Unit')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('Type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool_types');

        Schema::table('tool_catagories', function (Blueprint $table) {
            $table->dropColumn('tool_type_id');
            $table->string('Type')->after('Unit')->nullable();
        });
    }
}
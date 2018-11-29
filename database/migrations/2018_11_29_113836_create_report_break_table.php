<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportBreakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_break', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agent_name');
            $table->string('agent_id');
            $table->string('break_name');
            $table->dateTime('starttime');
            $table->dateTime('endtime');
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
        Schema::dropIfExists('report_break');
    }
}

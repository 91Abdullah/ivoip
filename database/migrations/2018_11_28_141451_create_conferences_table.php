<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('confno');
            $table->dateTime('starttime')->nullable();
            $table->dateTime('endtime')->nullable();
            $table->string('pin')->default('');
            $table->string('adminpin')->default('');
            $table->string('opts')->default('');
            $table->string('adminopts')->default('');
            $table->string('recordingfilename')->default('');
            $table->string('recordingformat')->default('');
            $table->integer('maxusers')->default(0);
            $table->integer('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conferences');
    }
}

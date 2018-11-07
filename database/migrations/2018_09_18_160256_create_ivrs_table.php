<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivrs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('announcement_id');
            $table->string('direct_dial')->default('disabled');
            $table->integer('timeout')->default(10);
            $table->string('invalid_retries')->default('disabled');
            $table->integer('invalid_retry_recording')->default(0);
            $table->boolean('append_announcement_invalid')->default(false);
            $table->boolean('return_on_invalid')->default(false);
            $table->integer('invalid_recording')->default(0);
            $table->integer('invalid_destination')->nullable();
            $table->string('timeout_retries')->default('disabled');
            $table->integer('timeout_retry_recording')->default(0);
            $table->boolean('append_announcement_timeout')->default(false);
            $table->boolean('return_on_timeout')->default(false);
            $table->integer('timeout_recording')->default(0);
            $table->integer('timeout_destination')->nullable();
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
        Schema::dropIfExists('ivrs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('system_recording_id');
            $table->string('repeat');
            $table->boolean('allow_skip');
            $table->boolean('return_to_ivr');
            $table->boolean('dont_answer_channel');
            $table->integer('announcementable_id');
            $table->string('announcementable_type');
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
        Schema::dropIfExists('announcements');
    }
}

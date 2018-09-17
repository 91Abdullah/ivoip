<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQueueLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('queue_log', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('time', 26)->default('');
			$table->string('callid', 40)->default('');
			$table->string('queuename', 20)->default('')->index('queue');
			$table->string('agent', 20)->default('');
			$table->string('event', 20)->default('')->index('event');
			$table->string('data', 100)->default('');
			$table->string('data1', 40)->default('');
			$table->string('data2', 40)->default('');
			$table->string('data3', 40)->default('');
			$table->string('data4', 40)->default('');
			$table->string('data5', 40)->default('');
			$table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('queue_log');
	}

}

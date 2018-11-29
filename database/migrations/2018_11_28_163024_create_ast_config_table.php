<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAstConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ast_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_metric');
            $table->integer('var_metric');
            $table->string('filename');
            $table->string('category');
            $table->string('var_name');
            $table->string('var_value');
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
        Schema::dropIfExists('ast_config');
    }
}

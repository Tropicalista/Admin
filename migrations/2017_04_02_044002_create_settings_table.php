<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->string('name');
            $table->string('handle')->unique();
            $table->text('value');
            $table->string('default');
            $table->text('description');
            $table->string('type', 500);

        });

        Schema::table('settings', function(Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('settings_groups')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }

}

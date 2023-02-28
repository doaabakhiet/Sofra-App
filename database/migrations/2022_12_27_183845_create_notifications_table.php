<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->longText('content');
			$table->morphs('user');
			$table->enum('isread',array('0', '1'))->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
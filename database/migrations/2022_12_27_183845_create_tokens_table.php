<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('user');
			$table->string('token');
			$table->string('type')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->string('image');
			$table->string('name');
			$table->longText('description')->nullable();
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration {

	public function up()
	{
		Schema::create('reviews', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->longText('coment');
			$table->enum('emoji', array('0', '1', '2', '3', '4'))->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('reviews');
	}
}
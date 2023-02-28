<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationRestaurantTable extends Migration {

	public function up()
	{
		Schema::create('classification_restaurant', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->integer('classification_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('classification_restaurant');
	}
}
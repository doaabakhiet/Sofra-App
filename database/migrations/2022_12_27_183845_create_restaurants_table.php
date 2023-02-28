<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('restaurant_name');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->integer('neighborhood_id')->unsigned();
			$table->string('password');
			$table->decimal('minimum_order', 10,2);
			$table->decimal('delivery_fees', 10,2);
			$table->string('delivery_phone');
			$table->string('delivery_watsapp_number');
			$table->integer('rating')->nullable();
			$table->string('image');
			$table->enum('status', array('0', '1'));
			$table->string('api_token')->nullable();
			$table->string('pincode')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
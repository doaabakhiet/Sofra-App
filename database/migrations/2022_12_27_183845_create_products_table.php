<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->longText('description');
			$table->decimal('price', 10,2);
			$table->decimal('offer_price', 10,2);
			$table->enum('has_offer', array('0', '1'));
			$table->string('order_preparation_time');
			$table->integer('restaurant_id')->unsigned();
			$table->string('image');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
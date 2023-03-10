<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('quantity');
			$table->longText('order_description')->nullable();
			$table->decimal('price', 10,2);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}
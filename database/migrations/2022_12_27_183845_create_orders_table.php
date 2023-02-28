<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->decimal('app_commission', 10,2)->nullable();
			$table->decimal('price', 10,2);
			$table->decimal('total_price', 10,2);
			$table->decimal('delivery_fees', 10,2)->nullable();
			$table->enum('status', array('delivered', 'declined', 'pending', 'accepted', 'rejected'))->default('pending');
			$table->enum('payment_method', array('cash_on_delivery', 'pay_online'));
			$table->longText('notes');
			$table->string('phone');
			$table->timestamps();
			$table->string('address');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
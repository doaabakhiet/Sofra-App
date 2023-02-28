<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesPaidTable extends Migration {

	public function up()
	{
		Schema::create('fees_paid', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->decimal('fees_paid')->nullable();
			$table->decimal('remaining_fees');
			$table->enum('payment_method', array('cash_on_delivery', 'pay_online'));
			$table->longText('notes');
			$table->datetime('payment_date');
			$table->enum('status', array('0,1'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('fees_paid');
	}
}
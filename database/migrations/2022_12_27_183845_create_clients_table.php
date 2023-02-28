<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->integer('neighborhood_id')->unsigned();
			$table->string('password');
			$table->string('api_token')->nullable();
			$table->string('pincode')->nullable();
			$table->enum('isactive', array('0', '1'))->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
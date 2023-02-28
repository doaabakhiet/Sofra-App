<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration {

	public function up()
	{
		Schema::create('contact_us', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('fullname');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->longText('message');
			$table->enum('type', array('complain', 'suggestion', 'Enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contact_us');
	}
}
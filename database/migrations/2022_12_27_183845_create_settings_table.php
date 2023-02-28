<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->longText('about_us')->nullable();
			$table->string('title');
			$table->string('favicon');
			$table->decimal('commision', 10,2);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
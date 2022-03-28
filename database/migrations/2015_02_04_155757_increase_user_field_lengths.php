<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseUserFieldLengths extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		// DB::statement('ALTER TABLE ' . DB::getTablePrefix() . 'users MODIFY column jobtitle varchar(100) null');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		// DB::statement('ALTER TABLE ' . DB::getTablePrefix() . 'users MODIFY column jobtitle varchar(50) null');
	}

}

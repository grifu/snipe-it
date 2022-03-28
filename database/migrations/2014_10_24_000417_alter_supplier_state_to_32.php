<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSupplierStateTo32 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// DB::statement('ALTER TABLE ' . DB::getTablePrefix() . 'suppliers MODIFY column state varchar(32) null');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// DB::statement('ALTER TABLE ' . DB::getTablePrefix() . 'suppliers MODIFY column state varchar(2) null');
	}

}

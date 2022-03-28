<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMacAddressToAsset extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('assets', function ($table) {
			$table->string('mac_address')->nullable()->default(NULL);
		});

		Schema::table('models', function ($table) {
			$table->boolean('show_mac_address')->default(0);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('assets', function ($table) {
			$table->dropColumn('mac_address');
		});

		Schema::table('models', function ($table) {
			$table->dropColumn('show_mac_address');
		});
	}

}

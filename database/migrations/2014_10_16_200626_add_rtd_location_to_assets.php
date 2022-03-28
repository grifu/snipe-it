<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRtdLocationToAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('assets', function ($table) {
            $table->integer('rtd_location_id')->nullable()->default(NULL);
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
            $table->dropColumn('rtd_location_id');
        });
	}

}

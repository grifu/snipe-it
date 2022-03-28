<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateDataToNewStatuses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// get newly added statuses from last migration
        $statuses = DB::table('status_labels')->where('name', 'Pending')->orWhere('name', 'Ready to Deploy')->get();

		foreach ($statuses as $status) {
			if ($status->name =="Pending") {
				$pending_id = array($status->id);
			} elseif ($status->name =="Ready to Deploy") {
				$rtd_id = array($status->id);
			}
		}

		// Pending
        $pendings = DB::table('assets')->where('status_id', null)->where('physical', '1')->get();


			foreach ($pendings as $pending) {
				DB::update('update ' . DB::getTablePrefix() . 'assets set status_id = ? where status_id IS NULL AND physical=1',$pending_id);

			}


		// Ready to Deploy
        $rtds = DB::table('assets')->where('status_id', 0)->where('physical', '1')->get();

		foreach ($rtds as $rtd) {
				//DB::update('update users set votes = 100 where name = ?', array('John'));
				DB::update('update ' . DB::getTablePrefix() . 'assets set status_id = ? where status_id = 0 AND physical=1',$rtd_id);

			}




	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}

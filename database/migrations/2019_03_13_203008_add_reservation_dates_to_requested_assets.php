<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReservationDatesToRequestedAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requested_assets', function (Blueprint $table) {
            //
            $table->integer('checkout_requests_id');
            $table->dateTime('expected_checkout');
            $table->dateTime('expected_checkin');
            $table->tinyInteger('request_state')->default(0);  // 0: waiting ; 1 - approved request; 2 - Denied request; 3 - Canceled; 4 - fulfilled
            $table->integer('responsible_id')->nullable()->default(null);
        });

       


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requested_assets', function (Blueprint $table) {
            //
            $table->dropColumn('checkout_requests_id');
            $table->dropColumn('expected_checkout');
            $table->dropColumn('expected_checkin');
            $table->dropColumn('request_state');
            $table->dropColumn('responsible');
        });
    }
}

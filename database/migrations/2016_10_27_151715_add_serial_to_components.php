<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSerialToComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components', function ($table) {
            $table->string('serial_number')->nullable()->default(null);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function ($table) {
            $table->dropColumn('serial_number');
        });

    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToManufacturer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manufacturers', function (Blueprint $table) {
            $table->string('url')->nullable()->default(null);
            $table->string('support_url')->nullable()->default(null);
            $table->string('support_phone')->nullable()->default(null);
            $table->string('support_email')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function ($table) {
            $table->dropColumn('url');
            $table->dropColumn('support_url');
            $table->dropColumn('support_phone');
            $table->dropColumn('support_email');
        });
    }
}

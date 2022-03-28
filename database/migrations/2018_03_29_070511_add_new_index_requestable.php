<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewIndexRequestable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout_requests', function (Blueprint $table) {
            $table->index(['user_id','requestable_id','requestable_type'], 'checkout_requests_user_id_requestable_id_requestable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkout_requests', function (Blueprint $table) {
            $table->dropIndex('checkout_requests_user_id_requestable_id_requestable_type');
        });
    }
}

<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class LogFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $now = new Carbon();
        try {
            DB::table('login_attempts')->insert(
                [
                    'username' => $event->credentials['username'],
                    'user_agent' => request()->header('User-Agent'),
                    'remote_ip' => request()->ip(),
                    'successful' => 0,
                    'created_at' => $now,
                ]
            );
        } catch (\Exception $e) {
            \Log::debug($e);
        }

    }
}

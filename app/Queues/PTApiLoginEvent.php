<?php

namespace App\Queues;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PTApiLoginEvent
{
    private $user_id;
    private $login; // 1: login, 0: logout

    /**
     * @param $user_id
     * @param $login
     */
    public function __construct($user_id, $login)
    {
        $this->user_id = $user_id;
        $this->login = $login;
        self::handle();
    }

    public function handle()
    {
        if ($this->login == 1) {
            User::find($this->user_id)->update([
                'last_active_start' => Carbon::now(),
                'status' => 1,
            ]);
        } else {
            User::find($this->user_id)->update([
                'last_active_end' => Carbon::now(),
                'status' => 0,
            ]);
        }
    }
}

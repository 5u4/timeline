<?php

namespace App\Http\Services;

use App\Models\Log;

class LogService
{
    /**
     * @param int $user_id
     * @param string $action
     * @param string $data
     * @return Log
     */
    public function log(int $user_id, string $action, string $data): Log
    {
        $log = new Log();

        $log->user_id = $user_id;
        $log->action = $action;
        $log->data = $data;

        $log->save();

        return $log;
    }
}
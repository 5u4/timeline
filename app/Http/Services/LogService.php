<?php

namespace App\Http\Services;

use App\Models\Log;

class LogService
{
    /**
     * @param string $username
     * @param string $action
     * @param string $data
     * @return Log
     */
    public function log(string $username, string $action, string $data): Log
    {
        $log = new Log();

        $log->username = $username;
        $log->action = $action;
        $log->data = json_decode($data);

        $log->save();

        return $log;
    }
}
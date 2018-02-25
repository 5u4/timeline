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
    public function log(string $username, string $action, string $data = null): Log
    {
        $log = new Log();

        $log->username = $username;
        $log->action = $action;
        $log->data = $data;

        $log->save();

        return $log;
    }
}
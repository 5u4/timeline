<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @property int id
 * @property string action
 * @property string data
 * @property string timestamp
 */
class Log extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'data' => json_decode($this->data),
            'timestamp' => $this->timestamp,
        ];
    }
}

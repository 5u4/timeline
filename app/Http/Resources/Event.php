<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @property int id
 * @property string username
 * @property string name
 * @property string description
 * @property string date
 * @property bool done
 * @property string deleted_at
 */
class Event extends Resource
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
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'done' => $this->done,
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at),
        ];
    }
}

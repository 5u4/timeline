<?php

namespace App\Http\Services;

use App\Models\Event;

/**
 * Class EventService
 * @package App\Service
 */
class EventService
{
    /**
     * @param string $username
     * @param string $name
     * @param string|null $description
     * @param string|null $date
     * @return Event
     */
    public function create(string $username, string $name, $description, $date): Event
    {
        $event = new Event();

        $event->username = $username;
        $event->name = $name;

        if (isset($description))
            $event->description = $description;

        if (isset($date))
            $event->date = $date;

        $event->save();

        return $event;
    }

}

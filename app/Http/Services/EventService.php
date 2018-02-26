<?php

namespace App\Http\Services;

use App\Models\Event;
use Illuminate\Http\JsonResponse;

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

        if (isset($description)) {
            $event->description = $description;
        }

        if (isset($date)) {
            $event->date = $date;
        }

        $event->save();

        return $event;
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $description
     * @param string|null $date
     * @param string|null $done
     * @return string
     */
    public function edit(int $id, $name, $description, $date, $done): string
    {
        $event = Event::find($id);

        $data = [];

        if (isset($name)) {
            $data['name'] = $name;
            $event->name = $name;
        }

        if (isset($description)) {
            $data['description'] = $description;
            $event->description = $description;
        }

        if (isset($date)) {
            $data['date'] = $date;
            $event->date = $date;
        }

        if (isset($done)) {
            $data['done'] = $done;
            $event->done = $done;
        }

        $event->save();

        return json_encode($data);
    }
}

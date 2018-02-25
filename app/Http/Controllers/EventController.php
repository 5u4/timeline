<?php

namespace App\Http\Controllers;

use App\Models\{Event, Log};
use App\Http\Services\{EventService, LogService};
use Illuminate\Http\{Request, JsonResponse, Response};
use Illuminate\Support\Facades\{
    Auth, DB, Validator
};
use App\Http\Resources\{Event as UserResource, EventCollection};

class EventController extends Controller
{
    /** @var EventService $eventService */
    private $eventService;
    /** @var LogService $logService */
    private $logService;

    /**
     * EventController constructor.
     * @param EventService $eventService
     * @param LogService $logService
     */
    public function __construct(EventService $eventService, LogService $logService)
    {
        $this->eventService = $eventService;
        $this->logService = $logService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $events = Event::where('username', $user->username)->get();

        return EventCollection::make($events)->response();
    }
}

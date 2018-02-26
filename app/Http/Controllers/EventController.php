<?php

namespace App\Http\Controllers;

use App\Models\{Event, Log};
use App\Http\Services\{EventService, LogService};
use Illuminate\Http\{Request, JsonResponse, Response};
use Illuminate\Support\Facades\{
    Auth, DB, Validator
};
use App\Http\Resources\{Event as EventResource, EventCollection};

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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        /* Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'date' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Create Event and Log Action */
        $event = DB::transaction(function () use ($request) {
            $user = Auth::user();

            $event = $this->eventService->create($user->username, $request->name, $request->description, $request->date);

            $data = json_encode([
                'name' => $request->name,
                'description' => $request->description,
                'date' => $request->date,
            ]);

            $this->logService->log($user->username, Log::CREATE_EVENT, $data);

            return $event;
        });

        return EventResource::make($event)->response();
    }
}

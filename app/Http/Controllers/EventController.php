<?php

namespace App\Http\Controllers;

use App\Models\{
    Event, Log, Tag
};
use App\Http\Services\{EventService, LogService};
use Illuminate\Http\{Request, JsonResponse, Response};
use Illuminate\Support\Facades\{
    Auth, DB, Validator
};
use App\Http\Resources\{
    Event as EventResource, EventCollection, TagCollection
};

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
     * @return JsonResponse
     */
    public function indexTrashed(): JsonResponse
    {
        $user = Auth::user();

        $events = Event::onlyTrashed()->where('username', $user->username)->get();

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

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $event = Event::find($id);

        if ($user->username != $event->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'date' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Edit Event and Log Action */
        $data = DB::transaction(function () use ($id, $request, $user) {
            $data = $this->eventService->edit($id, $request->name, $request->description, $request->date, $request->done);

            $this->logService->log($user->username, Log::EDIT_EVENT, json_encode($data));

            return $data;
        });

        return response()->json($data);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function showEventTags(int $id): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $event = Event::find($id);

        if ($user->username != $event->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Show Event Tags */
        $event = Event::find($id);

        return TagCollection::make($event->tags)->response();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function tag(int $id, Request $request): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $event = Event::find($id);

        if ($user->username != $event->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Tag Event and Log Action */
        $data = DB::transaction(function () use ($id, $request, $user, $event) {
            foreach ($request->tag_ids as $tag_id) {
                /* Tag Validation */
                $tag = Tag::find($tag_id);
                abort_if($tag->username != $user->username, Response::HTTP_BAD_REQUEST, 'Username does not match');

                $event->tags()->attach($tag_id);
            }

            $data = [
                'event_id' => $id,
                'tag_id' => $request->tag_ids,
            ];

            $this->logService->log($user->username, Log::TAG_EVENT, json_encode($data));

            return $data;
        });

        return response()->json($data);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $event = Event::find($id);

        if ($user->username != $event->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Delete Tag and Log Action */
        $event = DB::transaction(function () use ($id, $user) {
            $event = Event::withTrashed()->find($id);

            $event->delete();

            $this->logService->log($user->username, Log::DELETE_EVENT, json_encode(['id' => $id]));

            return $event;
        });

        return EventResource::make($event)->response();
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function restore(int $id): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $event = Event::onlyTrashed()->find($id);

        if ($user->username != $event->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Delete Tag and Log Action */
        $event = DB::transaction(function () use ($id, $user, $event) {
            $event->restore();

            $this->logService->log($user->username, Log::RESTORE_EVENT, json_encode(['id' => $id]));

            return $event;
        });

        return EventResource::make($event)->response();
    }
}

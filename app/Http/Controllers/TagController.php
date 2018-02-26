<?php

namespace App\Http\Controllers;

use App\Http\Services\LogService;
use App\Http\Services\TagService;
use App\Models\{
    Log, User, Tag
};
use Illuminate\Http\{
    Request, JsonResponse, Response
};
use Illuminate\Support\Facades\{DB, Auth, Validator};
use App\Http\Resources\{
    EventCollection, Tag as TagResource, TagCollection
};


class TagController extends Controller
{
    /** @var TagService $tagService */
    private $tagService;
    /** @var LogService $logService */
    private $logService;

    /**
     * TagController constructor.
     * @param TagService $tagService
     * @param LogService $logService
     */
    public function __construct(TagService $tagService, LogService $logService)
    {
        $this->tagService = $tagService;
        $this->logService = $logService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $tags = Tag::where('username', $user->username)->get();

        return TagCollection::make($tags)->response();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        /* Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|alpha_dash',
            'color' => 'required|size:6|regex:'.Tag::COLOR_REGEX
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Create Tag and Log Action */
        $tag = DB::transaction(function () use ($request) {
            $user = Auth::user();

            $tag = $this->tagService->create($user->username, $request->name, $request->color);

            $data = json_encode([
                'name' => $request->name,
                'color' => $request->color,
            ]);

            $this->logService->log($user->username, Log::CREATE_TAG, $data);

            return $tag;
        });

        return TagResource::make($tag)->response();
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

        $tag = Tag::find($id);

        if ($user->username != $tag->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'string|alpha_dash',
            'color' => 'size:6|regex:'.Tag::COLOR_REGEX
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Edit Tag and Log Action */
        $data = DB::transaction(function () use ($id, $request, $user) {
            $data = $this->tagService->edit($id, $request->name, $request->color);

            $this->logService->log($user->username, Log::EDIT_TAG, json_encode($data));

            return $data;
        });

        return response()->json($data);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function showTagEvents(int $id): JsonResponse
    {
        /* User Validation */
        $user = Auth::user();

        $tag = Tag::find($id);

        if ($user->username != $tag->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Show Tag Events */
        $tag = Tag::find($id);

        return EventCollection::make($tag->events)->response();
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

        $tag = Tag::find($id);

        if ($user->username != $tag->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Delete Tag and Log Action */
        $tag = DB::transaction(function () use ($id, $user) {
            $tag = Tag::withTrashed()->find($id);

            $tag->delete();

            $this->logService->log($user->username, Log::DELETE_TAG, json_encode(['id' => $id]));

            return $tag;
        });

        return TagResource::make($tag)->response();
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

        $tag = Tag::onlyTrashed()->find($id);

        if ($user->username != $tag->username) {
            throw new \Exception('Username does not match', Response::HTTP_BAD_REQUEST);
        }

        /* Restore Tag and Log Action */
        $tag = DB::transaction(function () use ($id, $user, $tag) {
            $tag->restore();

            $this->logService->log($user->username, Log::RESTORE_TAG, json_encode(['id' => $id]));

            return $tag;
        });

        return TagResource::make($tag)->response();
    }
}

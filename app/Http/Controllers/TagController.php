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
use App\Http\Resources\{Tag as TagResource, TagCollection};


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
            'username' => 'required|string|max:255|exists:users,username',
            'name' => 'required|string|alpha_dash',
            'color' => 'required|size:6|alpha_num'
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
}

<?php

namespace App\Http\Controllers;

use App\Http\Services\TagService;
use App\Models\{User, Tag};
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\{Tag as TagResource, TagCollection};


class TagController extends Controller
{
    /** @var TagService $tagService */
    private $tagService;

    /**
     * TagController constructor.
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
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
}

<?php

namespace App\Http\Controllers;

use App\Models\{User, Log};
use App\Http\Services\{UserService, LogService};
use Illuminate\Http\{Request, JsonResponse, Response};
use Illuminate\Support\Facades\{
    Auth, DB, Validator
};
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /** @var UserService $userService */
    private $userService;
    /** @var LogService $logService */
    private $logService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param LogService $logService
     */
    public function __construct(UserService $userService, LogService $logService)
    {
        $this->userService = $userService;
        $this->logService = $logService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        /* Validation */
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Create User and Log Action */
        $user = DB::transaction(function () use ($request) {
            $user = $this->userService->create($request->username, $request->password);

            $this->logService->log($user->username, Log::REGISTER);

            return $user;
        });

        return UserResource::make($user)->response();
    }

    public function login(Request $request): JsonResponse
    {
        /* Authentication */
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $response = ['data' => ['message' => 'Name/Password does not match']];
            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        /* Log */
        $this->logService->log($request->username, Log::LOGIN);

        return UserResource::make(User::where('username', $request->username)->first())->response();
    }
}

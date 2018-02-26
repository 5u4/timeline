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
            'username' => 'required|string|max:255|unique:users|alpha_dash',
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        /* Authentication */
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $response = ['data' => ['message' => 'Name/Password does not match']];
            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        /* Validation */
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], Response::HTTP_CONFLICT);
        }

        /* Change Password and Log Action */
        $user = DB::transaction(function () use ($request) {
            $user = Auth::user();

            $password = bcrypt($request->new_password);

            $data = [
                'old' => $user->password,
                'new' => $password
            ];

            $user->password = $password;
            $user->save();

            $this->logService->log($user->username, Log::CHANGE_PASSWORD, json_encode($data));

            return $user;
        });

        return UserResource::make($user)->response();
    }

    /**
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $user = DB::transaction(function () {
            $user = Auth::user();

            $user->delete();

            $this->logService->log($user->username, Log::DELETE_USER);

            return User::withTrashed()->where('username', $user->username)->first();
        });

        return UserResource::make($user)->response();
    }

    /**
     * @param string $username
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(string $username): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            throw new \Exception('Only Admin can delete user', Response::HTTP_BAD_REQUEST);
        }

        /* Delete User and Log Action */
        $deleted_user = DB::transaction(function () use ($username, $user) {
            $deleted_user = User::withTrashed()->where('username', $username)->first();

            $deleted_user->delete();

            $this->logService->log($user->username, Log::DELETE_USER, json_encode(['username' => $username]));

            return $deleted_user;
        });

        return UserResource::make($deleted_user)->response();
    }

    /**
     * @param string $username
     * @return JsonResponse
     * @throws \Exception
     */
    public function restore(string $username): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            throw new \Exception('Only Admin can restore user', Response::HTTP_BAD_REQUEST);
        }

        /* Restore User and Log Action */
        $restored_user = DB::transaction(function () use ($username, $user) {
            $restored_user = User::onlyTrashed()->where('username', $username)->first();

            $restored_user->restore();

            $this->logService->log($user->username, Log::RESTORE_USER, json_encode(['username' => $username]));

            return $restored_user;
        });

        return UserResource::make($restored_user)->response();
    }
}

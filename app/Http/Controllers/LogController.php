<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogCollection;
use App\Models\Log;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::user();

        $logs = Log::where('username', $user->username)->orderBy('id', 'DESC')->get();

        return LogCollection::make($logs)->response();
    }
}

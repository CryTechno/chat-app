<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CentrifugoProxyController extends Controller
{
    public function connect(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return new JsonResponse([
            'result' => [
                'user' => (string)$user->id,
                'channels' => ["personal:#" . $user->id],
            ]
        ]);
    }
}

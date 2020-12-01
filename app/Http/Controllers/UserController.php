<?php

/** @noinspection PhpUnhandledExceptionInspection, PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    final public function welcomeUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'email' => 'required|string|email',
            'platform' => 'required|string|in:Facebook,Google,Apple,Guest',
            'OS' => 'required|string|in:Android,iOS'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userData = $validator->validated();
        $user = User::where('user_id', '=', $userData['user_id'])->first();

        if ($user) {
            $user->update($userData + ['access_token' => sha1(uniqid('', true))]);
        }

        else {
            $user = User::create($userData + ['access_token' => sha1(uniqid('', true))]);
        }

        return response()->json([
            'access_token' => $user->access_token, 'coins' => $user->coins,  'trophies' => $user->trophies,
        ], 200);
    }

    final public function getAuthUser(): JsonResponse
    {
        return response()->json(['user' => request()->user()], 200);
    }

    final public function getUserCoinsAndTrophies(): JsonResponse
    {
        $user = request()->user();

        return response()->json([
            'coins' => $user->coins, 'trophies' => $user->trophies,
        ]);
    }
}
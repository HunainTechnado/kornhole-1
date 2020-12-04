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
            'name' => 'required|string',
            'image' => 'required|string',
            'user_id' => 'required|string',
            'email' => 'required|string|email',
            'platform' => 'required|string|in:Facebook,Google,Apple,Guest',
            'OS' => 'required|string|in:Android,iOS'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userData = $validator->validated();

        $image = base64_decode($userData['image']);
        $imagePath = public_path(uniqid('', true) . '.' . 'png');
        file_put_contents($imagePath, $image);
        $userData['image'] = $imagePath;

        $user = User::where('user_id', '=', $userData['user_id'])->first();

        if ($user) {
            $user->update($userData + ['access_token' => sha1(uniqid('', true))]);
        } else {
            $user = User::create(
                $userData + ['access_token' => sha1(uniqid('', true)), 'coins' => 0, 'trophies' => 0]
            );
        }

        return response()->json([
            'access_token' => $user->access_token, 'coins' => $user->coins, 'trophies' => $user->trophies,
        ]);
    }

    final public function getAuthUser(): JsonResponse
    {
        $user = request()->user();
        $user->image = base64_encode(file_get_contents($user->image));
        return response()->json(compact('user'), 200, [], JSON_UNESCAPED_SLASHES);
    }

    final public function getUser(User $user): JsonResponse
    {
        $user->image = base64_encode(file_get_contents($user->image));
        return response()->json(compact('user'), 200, [], JSON_UNESCAPED_SLASHES);
    }

    final public function getUserCoinsAndTrophies(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'coins' => 'nullable|numeric',
            'trophies' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = request()->user();
        $coinsAndTrophies = $validator->validated();
        $user->increment('coins', $coinsAndTrophies['coins'] ?? 0);
        $user->increment('trophies', $coinsAndTrophies['trophies'] ?? 0);

        return response()->json([
            'coins' => $user->coins, 'trophies' => $user->trophies,
        ]);
    }
}
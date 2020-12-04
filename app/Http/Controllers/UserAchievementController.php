<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAchievementController extends Controller
{
    final public function leaderboard(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'duration' => 'required|string|in:Day,Week,Month,Year,All',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


    }
}
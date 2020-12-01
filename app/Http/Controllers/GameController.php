<?php

/** @noinspection PhpUnhandledExceptionInspection, PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    final public function startMultiPlayerGame(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        $requestedUser = $request->user();
        $game = Game::whereRoomId($data['room_id'])->first();

        if (!$game) {
            $game = new Game($data + ['game_type' => 'Multiplayer', 'game_status' => 'Created']);
            $game->firstPlayer()->associate($requestedUser)->save();
        }

        else {
            $game->update(['game_status' => 'Started']);
            $game->secondPlayer()->associate($requestedUser)->save();
        }

        return response()->json(['game_id' => $game->id], 200);
    }

    final public function startSinglePlayerGame(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_mode' => 'required|string|in:Easy,Medium,Hard',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $game = new Game($validator->validated() + ['game_type' => 'Computer', 'game_status' => 'Started']);
        $game->firstPlayer()->associate($request->user())->save();

        return response()->json(['game_id' => $game->id], 200);
    }
}
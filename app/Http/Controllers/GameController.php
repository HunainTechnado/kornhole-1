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
        $game = Game::whereRoomId($data['room_id'])->wherePlayer2->first();

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

    final public function declareWinner(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|numeric|exists:games,id',
            'winning_coins' => 'required|numeric',
            'winning_trophies' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();
        $game = Game::whereId($request->get('game_id'))->whereGameStatus('Started')->whereNull('winner')->first();

        if ($game->firstPlayer->is($user)) {
            $game->update(['winner' => 'player_1']);
        }

        elseif ($game->secondPlayer->is($user)) {
            $game->update(['winner' => 'player_2']);
        }

        $user->increment('coins', $request->get('winning_coins'));
        $user->increment('trophies', $request->get('winning_trophies'));
        $game->update(['game_status' => 'Finished']);

        return response()->json(compact('user'));
    }
}
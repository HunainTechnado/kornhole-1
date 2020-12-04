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
            'player_2' => 'required|exists:users,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $game = new Game($validator->validated() + ['game_type' => 'Multiplayer']);
        $game->firstPlayer()->associate($request->user())->save();

        return response()->json(['game_id' => $game->id]);
    }

    final public function startSinglePlayerGame(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_mode' => 'required|string|in:Easy,Medium,Hard',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $game = new Game($validator->validated() + ['game_type' => 'Computer']);
        $game->firstPlayer()->associate($request->user())->save();

        return response()->json(['game_id' => $game->id]);
    }

    final public function declareWinner(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|numeric|exists:games,id',
            'winning_coins' => 'nullable|numeric|gt:0',
            'winning_trophies' => 'nullable|numeric|gt:0',
            'losing_coins' => 'nullable|numeric|lt:0',
            'losing_trophies' => 'nullable|numeric|lt:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        $winningPlayer = $request->user();

        $game = Game::whereId($data['game_id'])->whereGameStatus('Started')->whereNull('winner')->first();

        $game->update(['winner' => $game->firstPlayer->is($winningPlayer) ? 'player_1' : 'player_2']);
        $losingPlayer = $game->{$game->firstPlayer->is($winningPlayer) ? 'secondPlayer' : 'firstPlayer'};

        $game->update(['game_status' => 'Finished']);

        $winningPlayer->userAchievementsHistory()->create([
            'coins_change' => $data['winning_coins'], 'trophies_change' => $data['winning_trophies']
        ]);
        $winningPlayer->increment('coins', $data['winning_coins'] ?? 0);
        $winningPlayer->increment('trophies', $data['winning_trophies'] ?? 0);

        $losingPlayer->userAchievementsHistory()->create([
            'coins_change' => $data['losing_coins'], 'trophies_change' => $data['losing_trophies']
        ]);

        if ($data['losing_coins']) {
            if ($losingPlayer->coins + $data['losing_coins'] >= 0) {
                $losingPlayer->increment('coins', $data['losing_coins']);
            } else {
                $losingPlayer->update(['coins' => 0]);
            }
        }

        if ($data['losing_trophies']) {
            if ($losingPlayer->trophies + $data['losing_trophies'] >= 0) {
                $losingPlayer->increment('trophies', $data['losing_trophies']);
            } else {
                $losingPlayer->update(['trophies' => 0]);
            }
        }

        $winningPlayer->image = base64_encode(file_get_contents($winningPlayer->image));
        return response()->json(['user' => $winningPlayer]);
    }
}
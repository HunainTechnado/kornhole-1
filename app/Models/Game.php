<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $table = 'games';
    protected $fillable = ['room_id', 'player_1', 'player_2', 'game_type', 'winner', 'game_status'];

    final public function firstPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_1', 'user_id');
    }

    final public function secondPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_2', 'user_id');
    }
}
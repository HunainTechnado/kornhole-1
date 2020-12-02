<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    final public function up(): void
    {
        Schema::create('games', static function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->nullable()->unique();
            $table->string('player_1')->nullable();
            $table->string('player_2')->nullable();
            $table->enum('game_type', ['Multiplayer', 'Computer']);
            $table->enum('game_mode', ['Easy', 'Medium', 'Hard'])->nullable();
            $table->enum('winner', ['player_1', 'player_2'])->nullable();
            $table->enum('game_status', ['Created', 'Started', 'Finished'])->default('Created');
            $table->timestamps();
        });

        Schema::table('games', static function (Blueprint $table) {
            $table->foreign('player_1')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreign('player_2')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
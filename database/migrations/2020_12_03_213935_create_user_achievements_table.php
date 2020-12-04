<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAchievementsTable extends Migration
{
    final public function up(): void
    {
        Schema::create('user_achievements', static function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('coins_change');
            $table->integer('trophies_change');
            $table->timestamp('created_at');
        });

        Schema::table('user_achievements', static function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('user_achievements');
    }
}
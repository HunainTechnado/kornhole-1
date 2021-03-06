<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'users';
    protected $fillable = ['user_id', 'name', 'image', 'email', 'platform', 'OS', 'coins', 'trophies', 'access_token'];
    protected $hidden = ['password', 'access_token', 'created_at', 'updated_at'];

    final public function gamesAsFirstPlayer(): HasMany
    {
        return $this->hasMany(Game::class, 'player_1', 'user_id');
    }

    final public function gamesAsSecondPlayer(): HasMany
    {
        return $this->hasMany(Game::class, 'player_2', 'user_id');
    }

    final public function purchasedItems(): HasMany
    {
        return $this->hasMany(PurchasedItem::class, 'user_id', 'user_id');
    }

    final public function userAchievementsHistory(): HasMany
    {
        return $this->hasMany(UserAchievement::class, 'user_id', 'user_id');
    }
}

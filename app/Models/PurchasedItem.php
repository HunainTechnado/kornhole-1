<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasedItem extends Model
{
    protected $table = 'purchased_products';
    protected $fillable = ['user_id', 'item_id', 'item_name', 'item_price'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

    final public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
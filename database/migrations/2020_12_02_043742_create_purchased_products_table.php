<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedProductsTable extends Migration
{
    final public function up(): void
    {
        Schema::create('purchased_products', static function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('item_id');
            $table->string('item_name');
            $table->unsignedDecimal('item_price');
            $table->timestamps();
        });

        Schema::table('purchased_products', static function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('purchased_products');
    }
}
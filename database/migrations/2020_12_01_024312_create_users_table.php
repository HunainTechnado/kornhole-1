<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    final public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 191)->unique();
            $table->string('email', 191);
            $table->enum('platform', ['Facebook', 'Google', 'Apple', 'Guest']);
            $table->enum('OS', ['Android', 'iOS']);
            $table->unsignedInteger('coins')->default(0);
            $table->unsignedInteger('trophies')->default(0);
            $table->string('access_token')->nullable();
            $table->timestamps();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
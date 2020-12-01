<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    final public function register(): void
    {
        //
    }

    final public function boot(): void
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        $this->app['auth']->viaRequest('api', static function ($request) {
            if (!$request->header('Authorization')) {
                return null;
            }

            $key = explode(' ', $request->header('Authorization'));
            $user = User::where(DB::raw('BINARY `access_token`'), '=', $key[1])->first();
            if ($user) {
                $request->request->add(compact('user'));
            }

            return $user;
        });
    }
}

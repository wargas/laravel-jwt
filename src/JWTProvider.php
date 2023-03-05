<?php

namespace Bitmax\LaravelJwt;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class JWTProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configRoutes();
        Auth::viaRequest('api', function (Request $request) {
            $token = $request->bearerToken();

            if (!$token) {
                return null;
            }
            $userModel = app(config('auth.providers.users.model'));
            $key = new Key(env('APP_KEY'), 'HS256');

            $this->mergeConfigFrom(__DIR__ . './jwt.php', 'jwt');

            try {
                $payload = JWT::decode($token, $key);

                return $userModel->find($payload->id);
            } catch (Exception $e) {
                return null;
            }
        });
    }

    public function configRoutes()
    {
        Route::prefix(config('jwt.prefix'))->group(function () {
            Route::post('login', [JWTController::class, 'login']);
            Route::get('me', [JWTController::class, 'currentUser'])->middleware('auth:api');
        });
    }
}

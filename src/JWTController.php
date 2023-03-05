<?php 

namespace Bitmax\LaravelJwt;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JWTController {
    function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $userModel = app(config('auth.providers.users.model'));

        $user = $userModel->firstWhere('email', $request->email);

        if(!$user) {
            return new Response(['error' => 'INVALID_CREDENTIALS'], 401);
        }

        if(!Hash::check($request->password, $user->password)) {
            return new Response(['error' => 'INVALID_CREDENTIALS'], 401);
        }

        $token = JWT::encode([
            'id' => $user->id,
        ], env('APP_KEY'), 'HS256');

        return new Response(['token' => $token]);
    }

    public function currentUser() {
        return Auth::user();
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class AuthController extends Controller
{
    protected function generateAccessToken(User $user): string
    {
        $token = $user->createToken($user->email . '-' . now());
        return $token->accessToken;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|email',
//            'password' => 'required|min:6'
//        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken($user->email . '-' . now());

        return response()->json([
            'user' => $user,
            'token' => $token->accessToken
        ]);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken($user->email . '-' . now());
            return response()->json([
                'user' => $user,
                'token' => $token->accessToken
            ]);
        } elseif (Auth::attempt(['email' => $request->email])) {
            return response()->json(['message' => 'You have entered wrong password'], 400);
        } else {
            return response()->json(['message' => 'You have entered wrong email'], 400);
        }
    }

    public function autoLogin(Request $request ) {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken($user->email . '-' . now())
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }
}

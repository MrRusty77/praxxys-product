<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Users;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Inertia::render("Catalogue");
        }

        return Inertia::render("Auth/Login");
    }

    public function login(Request $request)
    {

        $auth = Auth::attempt(
            [
                'username' => $request->input('username'),
                'password' =>  $request->input('password'),
            ],
            $request->input('remember')
        );

        if (!$auth) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Users::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user_info' => $user,
            'token_type' => 'Bearer',
        ]);
    }

    public static function logout(Request $request)
    {
        try {
            Auth::user()->tokens()->delete();
            Auth::logout();
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            return $ex->getMessage();
        }

        return Inertia::render("Auth/Login");
    }
}

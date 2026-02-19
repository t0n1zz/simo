<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\User;
use Response;

class AuthController extends Controller
{
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login user and generate Sanctum token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        // Attempt to authenticate user
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        // Check if user account is active
        if($user->status == 0){
            auth()->logout();
            return response()->json(['error' => 'Maaf akun anda tidak aktif'], 401);
        }

        // Update login timestamp
        $user->login = Date::now();
        $user->update();

        // Generate Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Revoke the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }



    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        $userData = User::with('pus','cu','aktivis.pekerjaan_aktif.cu')->findOrFail($user->id);
        
        return response()->json([
            'access_token' => $token,
            'user' => $userData,
            'token_type' => 'bearer'
        ]);
    }
		
    public function guard()
    {
        return Auth::Guard('api');
    }

}

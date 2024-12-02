<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function signInWithGoogle(Request $request)
{
    $googleUser = Socialite::driver('google')->userFromToken($request->input('token'));


    $user = User::where('email', $googleUser->getEmail())->first();

    if ($user) {

        $user->update([
            'provider' => 'GOOGLE',
            'provider_id' => $googleUser->getId(),
            'name' => $googleUser->getName(),
            'social_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
        ]);
    } else {

        $user = User::create([
            'provider' => 'GOOGLE',
            'provider_id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
            'social_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
        ]);
    }


    if (!$user->customer) {
        $user->customer()->create([
            'full_name' => $user->name,
        ]);
    }


    $token = $user->createToken('mobile_device')->plainTextToken;
      return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ], 'User logged in successfully');
}

}

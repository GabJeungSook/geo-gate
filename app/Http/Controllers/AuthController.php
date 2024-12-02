<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use App\Http\Resources\UserDetailsResource;
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

 
    if (!$user->userDetails) {
        $user->userDetails()->create([
            'first_name' => $googleUser->user['given_name'] ?? null,
            'last_name' => $googleUser->user['family_name'] ?? null,
        ]);
    }


    $token = $user->createToken('mobile_device')->plainTextToken;

    return ApiResponse::success([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => new UserResource($user->load('userDetails')), 
    ], 'User logged in successfully');
}


public function userDetails(Request $request)
{
    $user = User::withRelations()->find($request->user()->id);

    return ApiResponse::success(
        new UserResource($user), // Pass the user resource with loaded relationships
        'User details retrieved successfully'
    );
}


    public function updateUserDetails(Request $request)
{
    $user = $request->user(); 


    $validated = $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'full_address' => 'nullable|string|max:500',
        'birthday' => 'nullable|date',
        'course_id' => 'nullable|exists:courses,id', 
    ]);

   
    if ($user->userDetails) {
        $user->userDetails->update($validated); 
    } else {
        $user->userDetails()->create($validated); 
    }

   
    return ApiResponse::success(
        new UserResource($user),
        'User details updated successfully'
    );
}
}

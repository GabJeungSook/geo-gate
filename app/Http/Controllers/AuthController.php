<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\UserDetailsResource;

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
        try {
            $googleUser = Socialite::driver('google')->userFromToken($request->input('token'));

            DB::beginTransaction();

           
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

            DB::commit();

            $token = $user->createToken('mobile_device')->plainTextToken;

            return ApiResponse::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user->load('userDetails.course.campus')),
            ], 'User logged in successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Google Sign-In Error: ' . $e->getMessage());
            return ApiResponse::error('Failed to sign in with Google.', 500);
        }
    }

    public function userDetails(Request $request)
    {
        $user = User::withRelations()->find($request->user()->id);

        return ApiResponse::success(
            new UserResource($user),
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

        DB::beginTransaction();

        try {
            if ($user->userDetails) {
                $user->userDetails->update($validated);
            } else {
                $user->userDetails()->create($validated);
            }

            DB::commit();

            return ApiResponse::success(
                new UserResource($user->load('userDetails.course.campus')),
                'User details updated successfully'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User Details Update Error: ' . $e->getMessage());
            return ApiResponse::error('Failed to update user details.', 500);
        }
    }
}

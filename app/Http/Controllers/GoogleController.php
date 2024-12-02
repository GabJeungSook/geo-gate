<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }
    
    public function callback()
{
    // Get the Google user details
    $googleUser = Socialite::driver('google')->user();

    // Find user with matching email and provider
    $user = User::where('email', $googleUser->getEmail())
                ->where('provider', 'CREDENTIALS')
                ->first();

    if ($user) {
        // Update existing user's details
        $user->update([
            'provider' => 'GOOGLE',
            'provider_id' => $googleUser->getId(),
            'name' => $googleUser->getName(),
            'social_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
        ]);
    } else {
        // Create a new user if not found
        $user = User::create([
            'provider' => 'GOOGLE',
            'provider_id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
            'social_avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
        ]);
    }

    // Log the user in
    Auth::login($user);

    // Redirect to home page or any intended URL
    return redirect('/');
}


}

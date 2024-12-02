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
        
        $googleUser = Socialite::driver('google')->user();
    
      
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
    
      
        Auth::login($user);
    
      
        return redirect()->intended('/');
    }
    


}

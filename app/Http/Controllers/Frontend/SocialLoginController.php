<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
class SocialLoginController extends Controller
{
	public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $checkUser = User::where('email', $googleUser->getEmail())->exists();

            if ($checkUser) {
                $user = User::where('email', $googleUser->getEmail())->first();
                $user->google_token = $googleUser->token;
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->avatar = $googleUser->getAvatar();
                $user->save();
            } else {
                $user = User::updateOrCreate([
                    'google_id' => $googleUser->id,
                ], [
                    'full_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(12)),
                    'is_email_verified'=>1,
                    'email_verified_at'=>now(),
                    'role'  => 1,
                    'role_type'  => "USER"
                ]);
            }
            Auth::login($user);
            return redirect('/');
        } catch (Exception $e) {
            return response()->route('frontend.sign-in',app()->getLocale());
        }
    }

    public function facebookCallback()
    {
        try {
                $facebookUser = Socialite::driver('facebook')->user();
                $checkUser = User::where('email', $facebookUser->getEmail())->exists();
        
                if ($checkUser) {
                    $user = User::where('email', $facebookUser->getEmail())->first();
                    $user->facebook_token = $facebookUser->token;
                    $user->avatar = $facebookUser->getAvatar();
                    $user->save();
                } else {
                    $user = User::updateOrCreate([
                        'facebook_id' => $facebookUser->id,
                    ], [
                        'facebook_id' => $facebookUser->id,
                        'full_name' => $facebookUser->getName(),
                        'email' => $facebookUser->getEmail(),
                        'facebook_token' => $facebookUser->token,
                        'avatar' => $facebookUser->getAvatar(),
                        'password' => Hash::make(Str::random(12)),
                        'is_email_verified'=>1,
                        'email_verified_at'=>now(),
                        'role'  => 1,
                        'role_type'  => "USER"
                    ]);
                }

                Auth::login($user);
                return redirect('/');
        } catch (Exception $e) {
            return response()->route('frontend.sign-in',app()->getLocale());
        }
    }

}
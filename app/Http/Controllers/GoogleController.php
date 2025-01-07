<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $user= Socialite::driver('google')->stateless()->user();
            $findusr= User::where('google_id', $user->id)->first();

            if($findusr) {
                Auth::login($findusr);
                return redirect('dashboard');
            }
            else {
                $newUsr= User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt($user->id)
                ]);

                Auth::login($newUsr);
                return redirect('dashboard');
            }
        } catch(Exception $e) {
            $e->getMessage();
        }
    }
}

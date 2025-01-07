<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserPictureController;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{

    // Function that deletes user
    public function destroyUsr() {
        $findUsr= User::find(auth()->user()->id);
        $deleteImg= (new UserPictureController)->destroy(auth()->user()->id);
        if($findUsr && $deleteImg && $findUsr->delete()) {
            return redirect('/');
        }
        return redirect('/settings')->with('Error');
    }

    // Function for changing user data
    // Phone, password, email etc.
    public function changeData() {

    }

    public function changePsw(SettingsRequest $request) {
        if($request->newPsw === $request->newPswRetype) {
            $user= User::find(auth()->user()->id);
            if(Hash::check($request->oldPsw, $user->password)) {
                $updated= $user->update([
                    'password' => Hash::make($request->newPsw)
                ]);

                if($updated) {
                    return redirect('/')->with('Password has changed');
                }
            }
        }
        return redirect('/settings')->with('Error');
    }
}

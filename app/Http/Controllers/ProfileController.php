<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserPictureController;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function updateProfile(ProfileUpdateRequest $request) {
        $user= User::find(Auth()->user()->id);
        $updated= $user->update([
            'name' => $request->name,
            'bio' => $request->bio
        ]);

        if($updated) {
            return redirect('/profile?id='. $user->id)->with('Success');
        }
        return redirect('/profile?id='. $user->id)->with('Validation Error');
    }

    public function show($id) {
        $sameUsr= false;
        $user= User::select('id', 'name', 'bio')->find($id);
        if(auth()->user()->id == $id) {
            $sameUsr= true;
        }
        $image= (new UserPictureController)->show($id);

        if($user && $image) {
            return response()->json(['user' => $user, 'image'=> $image, 'sameUsr' => $sameUsr], 200);
        }
        return response()->json('Not found', 404);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\UserPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserPictureController extends Controller
{
    // user_id
    public function show($id) {
        $image= UserPicture::where('user_id', $id)->first();
        if($image) {
            return $image;
        }
        return 'err';
    }

    // user_id
    public function destroy($id) {
        $userImg= UserPicture::where('user_id', $id)->first();
        if($userImg->path == '/storage/images/default_user_picture.jpg') {
            return response()->json('Success', 201);
        }
        
        if(Storage::delete($userImg->path)) {
            return response()->json('Success', 201);
        }
        return response()->json('Error', 404);
    }

    // need to have the request and the user_id
    public function update(Request $request, $id) {
        $validated= Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        if($validated->fails()) {
            return response()->json('Error', 400);
        } 

        $oldImage= UserPicture::where('user_id', $id)->first();
        $image= $request->image;
        if($oldImage->path == '/storage/images/default_user_picture.jpg') {
            $oldImage->delete();
        }

        else {
            $oldImage->delete();
            Storage::delete($oldImage->path);
        }
        
        $path= $image->store('uploads');
        $ext= $image-> getClientOriginalExtension();
        $newImage= UserPicture::create([
            'path' => $path,
            'ext' => $ext,
            'user_id' => $id
        ]);

        if($newImage) {
            return redirect('profile');
        }
        return response()->json('Picture not added', 400);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ItemPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemPictureController extends Controller
{

    // Path, ext
    public function store($image, $id) {
        $path= $image->store('uploads');
        $ext= $image->getClientOriginalExtension();
        $picture= ItemPicture::create([
            'path' => $path,
            'ext' => $ext,
            'item_id' => $id
        ]);

        if($picture) {
            return response()->json('Picture added!', 201);
        }
        return response()->json('Picture not created!', 400);
    }
    //where $id is the item_id
    public function show($id) {
        $picture= ItemPicture::where('item_id', $id)->first();
        if($picture) {
            return $picture;
        }
        return response()->json('Error!', 404);
    }

    // Fix the delet mechanism
    public function destroy($id) {
        $itemPicture= ItemPicture::where('item_id', $id)->first();
        if(Storage::delete($itemPicture->path) ) {
            return response()->json('Success', 201);
        }
        return response()->json('Error!', 404);
    }

    // put 
    public function update($image, $id) {
        $picture= ItemPicture::where('item_id', $id)->first();
        Storage::delete($picture->path);
        $picture->delete();
        $path= $image->store('uploads');
        $ext= $image->getClientOriginalExtension();
        $picture= ItemPicture::create([
            'path' => $path,
            'ext' => $ext,
            'item_id' => $id
        ]);

        if($picture) {
            return response()->json('Picture added!', 201);
        }
        return response()->json('Picture not created!', 400);
    }
}

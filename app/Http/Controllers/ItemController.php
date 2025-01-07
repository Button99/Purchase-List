<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemList;
use App\Models\ItemListItem;
use App\Http\Controllers\ItemPictureController;
use App\Http\Requests\ItemStoreRequest;

class ItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemStoreRequest $request)
    {

        $item= new Item([
            'name' => $request->name,
            'description' => $request->description,
            'link' => $request->link,
            'price' => $request->price,
            'has_been_bought' => $request->hasBeenBought,
            'user_id' => auth()->user()->id
        ]);

        if($item->save()) {
            $itemList= ItemList::find($request->lists);
            $item->lists()->attach($itemList);

            if((new ItemPictureController)->store($request->image, $item->id)) {
                return redirect()->route('dashboard');
            }
        }
        return redirect()->route('addItem');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show(Request $request)
    {
        $item= Item::find($request->id);
        $itemPicture= (new ItemPictureController)->show($request->id);
        if(auth()->user()->id == $item->lists[0]->user_id) {
            return Inertia::render('ShowItem', ['item' => $item, 'picture' => $itemPicture]);
        }
        return response()->json('Not found!', 404);
    }

    public function getItems(Request $request) {

        $items= ItemList::find($request->id);
        if(auth()->user()->id == $items->user_id) {
            return response()->json($items->items, 200);
        }
        return response()->json('Not found!', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated= Validator::make($request->all(), [
            'name' => ['required', 'max:50', 'min: 2'],
            'description' => ['required', 'max:600'],
            'link' => ['required', 'url'],
            'price' => ['required', 'numeric'],
            'hasBeenBought' => ['required', 'boolean'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        $item= Item::find($id);
        $itemListItem= ItemListItem::where('item_id', $id)->get();
        if(!$validated->fails() && auth()->user()->id == $item->lists[0]->user_id) {
            $item->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'link' => $request->link,
                'has_been_bought'=> $request->hasBeenBought
            ]);
            $itemPicture= (new ItemPictureController)->update($request->image, $item->id);
            $item->lists()->sync([1 => ['item_id' => $item->id, 'item_list_id' => $itemListItem[0]->item_list_id]]);
            if($item && $itemPicture) {
                return redirect()->route('dashboard')->with('message', 'Item updated Successfully!');
            }
        }

        return redirect()->back()->with('message', 'Item did not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    // Attach the delete image method.
    public function destroy(Request $request)
    {
        $item= Item::find($request->id);
        if(auth()->user()->id == $item->lists[0]->user_id) {
            $itemPicture= (new ItemPictureController)->destroy($request->id);
            $item->lists()->detach($item);
            $item->delete();
            return redirect()->route('dashboard');
        }
        return response()->json('Not found!', 404);
    }

    public function getItem($id) {
        $item= Item::find($id);
        if(auth()->user()->id == $item->lists[0]->user_id) {
            return response()->json(['item' => $item], 200);
        }
        return response()->json('Not found!', 404);
    }
}

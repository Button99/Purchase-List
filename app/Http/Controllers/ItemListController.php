<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use App\Models\ItemListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ListStoreRequest;
use App\Http\Requests\ListUpdateRequest;
use App\Http\Requests\ListDeleteRequest;

class ItemListController extends Controller
{
    // Store a list
    public function store(ListStoreRequest $request) {
        $itemList= new ItemList([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'tag' => $request->tag,
            'public' => $request->public
        ]);
        
        if($itemList->save()) {
            return redirect('/dashboard')->with('Success');
        }
        return redirect('/addList')->with('Validation Errors');

    }

    public function getLists() {
        $id= auth()->user()->id;
        $lists= ItemList::where('user_id', $id)->orderBy('created_at')->get();

        if($lists) {
            return response()->json($lists, 200);
        }

        return response()->json('', 200);
    }

    public function deleteList(ListDeleteRequest $request) {

        $list= ItemList::find($request->id);
        $list->items()->detach($list->id);
        if($list->user_id == auth()->user()->id && $list->delete()) {
            return redirect('/showLists')->with('Success');
        }
        
        return response()->json('Item could not be deleted!', 400);
    }

    public function updateList(ListUpdateRequest $request) {
        $itemList= ItemList::find($request->id);
        $items= ItemListItem::where('item_list_id', $request->id)->get();
        if($itemList->user_id == auth()->user()->id) {
            $itemList->items()->sync($items);
            $success= $itemList->update([
                'name' => $request->name,
                'tag' => $request->tag,
                'public' => $request->public
            ]);

            if($success) {
                return redirect('/dashboard')->with('success');
            }
            return response()->json('Err', 400);
        }
    }
    
    public function show(Request $request) {

        $validated= Validator::make($request->all(), [
            'id' => ['required', 'integer']
        ]);

        if($validated->fails()) {
            $itemList= ItemList::find($request->id);
            if($itemList->user_id == auth()->user()->id) {
                return response()->json($itemList, 200);
            }
        }

        return response()->json('Not found', 404);
    }

    public function getListName(Request $request) {
        $name= ItemList::find($request->id)->name;
        return response()->json($name, 200);
    }

    public function totalListsAndItems() {
        $lists= auth()->user()->hasManyItemLists;
        $items= $lists->flatMap(function ($list) {
            return $list->items;
        });

        return response()->json(['listsNum' => $lists->count(), 'itemsNum' => $items->count()], 200);
    }
}

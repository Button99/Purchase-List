<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ItemList;
use Inertia\Inertia;

class AdminPanelController extends Controller
{
    public function viewUsers(Request $request) {
        if(auth()->user()->IS_ADMIN === 1) {
            $users= User::all();
            return Inertia::render('Admin/UserList', ['users' => $users]);
        }
        return redirect('/');
    }

    public function viewLists(Request $request) {
        if(auth()->user()->IS_ADMIN === 1) {
            $lists= ItemList::all();
            Inertia::render('Admin/ItemList', ['lists' => $lists]);
        }
        return redirect('/');
    }

    public function deleteUser(Request $request): void {
        if(isset($request->id)) {
            $findUsr= User::find($request->id);
            // $deleteImg= (new UserPictureController)->destroy($request->id);
            if($findUsr && $findUsr->delete()) {
                AdminPanelController::viewUsers($request);
            }
        }
    }

    public function addWarning(Request $request): void {
        if(isset($request->id)) {
            $user= User::find($request->id);
            if($user->WARNINGS >= 3) {
                $findUsr= User::find($request->id);
                $findUsr->delete();
            } else {
                $user->increment('warnings');
                $user->save();
            }
        }
        AdminPanelController::viewUsers($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    // Here we will implement the search function
    public function search(Request $request) {
        $users= User::select('id', 'name')->where('name', 'LIKE', '%', $request->name)->paginate(5);
        if($users) {
            return response(['users' => $users], 200);
        }
        return response()->json('No users found!', 404);
    }
}

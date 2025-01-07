<?php

use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserPictureController;
use App\Models\ItemList;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\EventListener\ProfilerListener;
use App\Http\Controllers\AdminPanelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/id', function () {
        return auth()->user()->id;
    });

    Route::get('/isAdmin', function () {
        return auth()->user()->IS_ADMIN;
    });

    Route::controller(ItemController::class)->group(function() {
        Route::post('/addItem/store', 'store')->name('item.store');

        Route::get('/getItems/{id}', 'getItems')->name('item.get');

        Route::get('/showItem/{id}', 'show')->name('item.data');

        Route::get('/showItem/{id}/get', 'getItem');

        Route::delete('/showItem/{id}/delete', 'destroy')->name('item.delete');

        Route::post('/showItem/{id}/edit', 'update')->name('item.edit');
    });

    Route::controller(SettingsController::class)->group(function() {
        Route::get('/settings/data', 'showData')->name('showData');

        Route::delete('/settings/delete', 'destroyUsr')->name('deleteAccount');

        Route::put('/settings/changePassword', 'changePsw')->name('changePsw');
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['user' => auth()->user()->name]);
    })->name('dashboard');

    Route::get('/addItem', function () {
        return Inertia::render('AddItem', ['user' => auth()->user()->name]);
    })->name('addItem');

    Route::get('/showItem/{id}/editPage', function () {
        return Inertia::render('EditItem');
    })->name('itemPage');

    Route::get('/displayItems/{id}', function() {
        return Inertia::render('DisplayItems');
    })->name('displayItems');

    Route::get('/settings', function() {
        return Inertia::render('Settings', ['user' => auth()->user()]);
    })->name('settings');

    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('updateProfile');

    Route::get('/addList', function() {
        return Inertia::render('AddList');
    })->name('addList');

    Route::get('/editList/{id}', function() {
        return Inertia::render('EditList');
    })->name('editList');

    Route::controller(ItemListController::class)->group(function() {
        Route::post('/addList/store', 'store');

        Route::get('/itemList/getLists', 'getLists');

        Route::put('/itemList/update/{id}', 'updateList');

        Route::get('/itemList/show/{id}', 'show');

        Route::get('/itemList/{id}/getName', 'getListName');

        Route::get('/itemList/getTotalLists', 'totalListsAndItems');

        Route::delete('/itemList/delete/{id}', 'deleteList');
    });

    Route::get('/showLists', function() {
        return Inertia::render('ShowLists');
    })->name('showLists');

    Route::get('/adminPanel', function() {
        if(auth()->user()->IS_ADMIN === 1) {
            return Inertia::render('Admin/AdminPanel', ['user' => auth()->user()->name]);
        }
        return redirect('/');
    })->name('adminPanel');
    // Create admin controller 
    Route::controller(AdminPanelController::class)->group(function() {
        Route::get('/viewUsers', 'viewUsers')->name('viewUsers');

        Route::get('/viewLists', 'viewLists')->name('viewLists');

        Route::delete('/deleteAccount/{id}', 'deleteUser')->name('deleteUser');
            
        Route::post('/addWarning', 'addWarning')->name('addWarning');
    });

    Route::controller('users', 'UserController');
});

Route::controller(GoogleController::class)->group(function() {
    Route::get('auth/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('/profile', function () {
    return Inertia::render('Profile');
})->name('profile');

Route::controller(ProfileController::class)->group(function() {
    Route::get('profile/{id}', 'show');
});

Route::controller(UserPictureController::class)->group(function() {
    Route::post('profile/{id}/changeImageProfile', 'update');
});

Route::controller(SearchController::class)->group(function() {
    Route::get('users/search', 'search');
});

Route::get('/faq', function () {
    return Inertia::render('Faq', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);})->name('faq');

Route::get('/search', function() {
    return Inertia::render('Search');
})->name('search');

Route::get('/changelog', function () {
    return Inertia::render('Changelog');
})->name('changelog');

require __DIR__.'/auth.php';

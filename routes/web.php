<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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
    return Inertia::render('Welcome');
});

Route::get('/upload', function() {

});


Route::get('/login', function() {
    return Socialite::driver('discord')->redirect();
});

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('discord')->user();
    $userRecord = User::where('discord_id', '=', $user->getId())->first();
    if($userRecord === null) {
        $userRecord = new User;
        $userRecord->name = $user->getName();
        $userRecord->nickname = $user->getNickname();
        $userRecord->avatar = $user->getAvatar();
        $userRecord->email = $user->getEmail();
        $userRecord->discord_id = $user->getId();
        $userRecord->save();
    }
    Auth::login($userRecord, true);
    return redirect('/');
});

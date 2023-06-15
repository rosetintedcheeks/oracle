<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/auth/callback', function () {
    $user = Socialite::driver('discord')->user();
    $userRecord = new User;
    $userRecord->name = $user->getName();
    $userRecord->nickname = $user->getNickname();
    $userRecord->avatar = $user->getAvatar();
    $userRecord->email = $user->getEmail();
    $userRecord->discord_id = $user->getId();
    $userRecord->save();
    return redirect('/');
});

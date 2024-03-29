<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TorrentController;
use App\Models\LinkRoot;
use App\Models\Series;
use App\Models\User;
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
})->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/torrents', function () {
        return Inertia::render('Torrents', [
            'linkRoots' => LinkRoot::all(),
            'series' => Series::all(),
        ]);
    })->name('torrents.index');

    Route::get('/torrents/choose', function (array $file_names) {
        return Inertia::render('TorrentChooseFiles', [
            'fileNames' => $file_names,
        ]);
    })->name('torrents.choose');

    Route::post('/torrents/upload', [TorrentController::class, 'uploadAction']);
    Route::post('/torrents/choose', [TorrentController::class, 'chooseAction']);

    Route::resource('/links', LinkController::class);
    Route::resource('/series', SeriesController::class);
});

Route::get('/login', function () {
    if ('local' == config('app.env')) {
        Auth::login(User::find(1));

        return to_route('home');
    }

    return Socialite::driver('discord')->redirect();
})->name('login');

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/');
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('discord')->user();
    $userRecord = User::where('discord_id', '=', $user->getId())->first();
    if (null === $userRecord) {
        $userRecord = new User();
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

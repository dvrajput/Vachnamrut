<?php

use App\Http\Controllers\User\SongsController as UserSongController;
use App\Http\Controllers\User\CategoriesController as UserCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('user.songs.index');
});

Route::name('user.')->group(function () {
    Route::resource('songs', UserSongController::class);
    Route::resource('categories', UserCategoriesController::class);
});
Route::get('/language/{locale}', function ($locale) {
    session()->put('locale', $locale);
    // dump($locale);
    return redirect()->back();
})->name('locale');


require __DIR__.'/admin.php';
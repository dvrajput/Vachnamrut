<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\User\SongsController as UserSongController;
use App\Http\Controllers\User\CategoriesController as UserCategoriesController;
use App\Http\Controllers\User\ContactController as UserContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('user.kirtans.index');
});
// Redirect /categories to home
Route::get('/categories', function() {
    return redirect()->route('user.kirtans.index');
});

Route::name('user.')->group(function () {
    Route::resource('kirtans', UserSongController::class);
    Route::resource('categories', UserCategoriesController::class)->except(['index']);
    Route::resource('contact', UserContactController::class);
});
Route::get('/language/{locale}', function ($locale) {
    session()->put('locale', $locale);
    // dump($locale);

    if (auth()->check()) {
        $user = auth()->user();
        $user->language = $locale;
        $user->save();
    }

    return redirect()->back();
})->name('locale');

//API
Route::prefix('api/')->group(function () {
    Route::get('get_songs', [ApiController::class, 'getSongs']);
    Route::get('get_sub_category', [ApiController::class, 'getSubCategory']);
    Route::get('get_category', [ApiController::class, 'getCategory']);
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// admin panel route
require __DIR__ . '/admin.php';

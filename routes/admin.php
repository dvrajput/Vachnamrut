<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\PlaylistsController as AdminPlaylistsController;
use App\Http\Controllers\Admin\SongsController as AdminSongController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect()->route('admin.loginPage');
});

Route::prefix('admin/')->name('admin.')->group(function () {

    Route::middleware(['admin_guest'])->group(function () {

        Route::get('login', [AuthController::class, 'showLoginPage'])->name('loginPage');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    Route::middleware(['admin_auth'])->group(function () {

        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        Route::resource('songs', AdminSongController::class);

        Route::resource('categories', AdminCategoriesController::class);

        Route::resource('playlists', AdminPlaylistsController::class);

        Route::resource('subCategories', AdminSubCategoryController::class);
        Route::get('subCategories/{id}/associated-songs', [AdminSubCategoryController::class, 'fetchAssociatedSongs'])->name('subCategories.associated_songs');
        Route::get('subCategories/{id}/remaining-songs', [AdminSubCategoryController::class, 'fetchRemainingSongs'])->name('subCategories.remaining_songs');
        Route::post('song_category_rel', [AdminSubCategoryController::class, 'addSongToCategory'])->name('subCategories.addSong');
        Route::delete('song_category_rel/{song_code}', [AdminSubCategoryController::class, 'removeSongFromCategory'])->name('subCategories.removeSong');
    });
});

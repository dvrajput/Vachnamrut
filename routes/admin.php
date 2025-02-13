<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\PlaylistsController as AdminPlaylistsController;
use App\Http\Controllers\Admin\SongsController as AdminSongController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\ConfigController as AdminConfigController;
use App\Http\Controllers\Admin\ContactsController as AdminContactsController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\LogsController;
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
        Route::get('search', [AdminPlaylistsController::class, 'search'])->name('songSearch');

        // Route::resource('', AdminExportController::class);
        Route::get('exports/index', [AdminExportController::class, 'index'])->name('exports.index');
        Route::get('exports', [AdminExportController::class, 'export'])->name('exports');

        Route::resource('config', AdminConfigController::class);

        Route::resource('contacts', AdminContactsController::class);

        Route::resource('subCategories', AdminSubCategoryController::class);
        Route::get('subCategories/{id}/associated-songs', [AdminSubCategoryController::class, 'fetchAssociatedSongs'])->name('subCategories.associated_songs');
        Route::get('subCategories/{id}/remaining-songs', [AdminSubCategoryController::class, 'fetchRemainingSongs'])->name('subCategories.remaining_songs');
        Route::post('song_category_rel', [AdminSubCategoryController::class, 'addSongToCategory'])->name('subCategories.addSong');
        Route::delete('song_category_rel/{song_code}', [AdminSubCategoryController::class, 'removeSongFromCategory'])->name('subCategories.removeSong');
        
        Route::resource('users', AdminUsersController::class);
        // Logs routes
        Route::get('logs', [LogsController::class, 'getSongLogs'])->name('admin.logs.index');
        Route::get('logs/song', [LogsController::class, 'getSongLogs'])->name('admin.logs.index');
        Route::get('logs/categories', [LogsController::class, 'getCategoryLogs'])->name('admin.logs.categories');
        Route::get('logs/subcategories', [LogsController::class, 'getSubcategoryLogs'])->name('admin.logs.subcategories');
        Route::get('logs/playlists', [LogsController::class, 'getPlaylistLogs'])->name('admin.logs.playlists');
    });
});

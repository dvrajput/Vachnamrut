<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\User\SongsController as UserSongController;
use App\Http\Controllers\User\CategoriesController as UserCategoriesController;
use App\Http\Controllers\User\ContactController as UserContactController;
use Illuminate\Support\Facades\Route;

// Change root route to show categories as homepage instead of kirtans
Route::get('/', [UserCategoriesController::class, 'index'])->name('home');

// Add this with your other admin routes
Route::get('/admin/logs/users', [App\Http\Controllers\Admin\LogsController::class, 'getLogUsers'])->name('admin.logs.users');

// Redirect /categories to home (now that home shows categories)
Route::get('/categories', function () {
    return redirect()->route('home');
});

// Keep existing kirtans redirect for backward compatibility
// Route::get('/kirtans', function () {
//     return redirect()->route('user.kirtans.index');
// });

// Add these routes in the admin group
Route::post('/admin/contacts/{id}/approve', [App\Http\Controllers\Admin\ContactsController::class, 'approve'])->name('admin.contacts.approve');
Route::post('/admin/contacts/{id}/reject', [App\Http\Controllers\Admin\ContactsController::class, 'reject'])->name('admin.contacts.reject');

Route::post('/admin/contacts/bulk-delete', [App\Http\Controllers\Admin\ContactsController::class, 'bulkDelete'])->name('admin.contacts.bulk-delete');
Route::post('/admin/contacts/delete-all', [App\Http\Controllers\Admin\ContactsController::class, 'deleteAll'])->name('admin.contacts.delete-all');

Route::name('user.')->group(function () {
    Route::resource('kirtans', UserSongController::class);
    Route::resource('categories', UserCategoriesController::class)->except(['index']); // Remove index since root route handles it
    Route::resource('contact', UserContactController::class);
    Route::get('{alias}/{id}', [UserCategoriesController::class, 'aliasSongShow'])
        ->name('categories.aliasSongShow')
        ->where('alias', '^(?!admin|api|language).*$')  // Exclude admin, api, language
        ->where('id', '[0-9]+');  // Only numeric IDs

    Route::get('{alias}', [UserCategoriesController::class, 'aliasShow'])
        ->name('categories.aliasShow')
        ->where('alias', '^(?!admin|api|language|test-route|categories|kirtans|contact).*$');
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

// Route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// });

// admin panel route
// require __DIR__ . '/admin.php';

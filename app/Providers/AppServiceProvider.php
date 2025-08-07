<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\SubCategory;
use App\Observers\CategoryObserver;
use App\Observers\PlaylistObserver;
use App\Observers\SongObserver;
use App\Observers\SubCategoryObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (app()->environment('production')) {
        URL::forceScheme('https');
        }
        Song::observe(SongObserver::class);
        Playlist::observe(PlaylistObserver::class);
        Category::observe(CategoryObserver::class);
        SubCategory::observe(SubCategoryObserver::class);
    }
}

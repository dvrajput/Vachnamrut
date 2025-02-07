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
        Song::observe(SongObserver::class);
        Playlist::observe(PlaylistObserver::class);
        Category::observe(CategoryObserver::class);
        SubCategory::observe(SubCategoryObserver::class);
    }
}

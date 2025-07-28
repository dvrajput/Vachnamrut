<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\SongPlaylistRel;
use App\Models\SubCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories for homepage
        $categories = DB::table('categories')
            ->orderBy('category_en')
            ->get();
        
        $locale = app()->getLocale();
        
        // Transform categories to include current locale title
        $categoriesTransformed = $categories->map(function ($category) use ($locale) {
            $category->title = $category->{'category_' . $locale};
            return $category;
        });
        
        return view('user.category.index', compact('categoriesTransformed', 'locale'));
    }

    public function aliasSongShow(Request $request, string $code, string $id)
    {
        // Get the category
        $category = DB::table('categories')->where('alias', $code)->first();
        
        if (!$category) {
            abort(404, 'Category not found.');
        }

        // Get specific song/Vachanamrut from this category
        $song = DB::table('song_cate_rels')
            ->join('songs', 'song_cate_rels.song_code', '=', 'songs.song_code')
            ->where('song_cate_rels.category_code', $category->category_code)
            ->where('songs.song_code', $id)
            ->first();
        
        if (!$song) {
            abort(404, 'Vachanamrut not found.');
        }

        return view('user.category.alias_song_show', compact('category', 'song'));
    }

    public function aliasShow(Request $request, string $code)
    {
        // Get the category
        $category = DB::table('categories')->where('alias', $code)->first();
        
        if (!$category) {
            abort(404, 'Category not found.');
        }

        if ($request->ajax()) {
            // FIXED: Query songs only from this specific category
            $query = DB::table('song_cate_rels')
                ->join('songs', 'song_cate_rels.song_code', '=', 'songs.song_code')
                ->where('song_cate_rels.category_code', $category->category_code);

            if ($request->has('search') && !empty($request->search)) {
                $keyword = '%' . $request->search . '%';
                $query->where(function($q) use ($keyword) {
                    $q->where('songs.title_en', 'LIKE', $keyword)
                      ->orWhere('songs.title_gu', 'LIKE', $keyword)
                      ->orWhere('songs.lyrics_en', 'LIKE', $keyword)
                      ->orWhere('songs.lyrics_gu', 'LIKE', $keyword);
                });
            }

            $locale = app()->getLocale();
            
            // Get the songs with pagination
            $songs = $query->orderBy('songs.title_' . $locale, 'asc')
                ->select('songs.*') // Select all song fields
                ->paginate(30);

            // Transform the songs to include the current locale's title as 'title'
            $songsTransformed = $songs->map(function ($song) use ($locale) {
                $song->title = $song->{'title_' . $locale};
                return $song;
            });

            return response()->json([
                'songs' => $songsTransformed,
                'locale' => $locale,
                'pagination' => [
                    'current_page' => $songs->currentPage(),
                    'last_page' => $songs->lastPage(),
                    'per_page' => $songs->perPage(),
                    'total' => $songs->total(),
                    'has_more_pages' => $songs->hasMorePages()
                ]
            ]);
        }

        return view('user.category.alias_show', compact('category'));
    }
}

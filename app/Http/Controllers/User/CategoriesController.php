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
            ->where('songs.vachnamrut_code', $id)
            ->first();

        if (!$song) {
            abort(404, 'Vachanamrut not found.');
        }

        // Get all songs in this category for navigation (ordered by creation or specific order)
        $songsInPlaylists = DB::table('song_cate_rels')
            ->join('songs', 'song_cate_rels.song_code', '=', 'songs.song_code')
            ->where('song_cate_rels.category_code', $category->category_code)
            ->orderBy('song_cate_rels.id', 'asc') // or use another ordering field like 'songs.created_at'
            ->select('songs.*', 'song_cate_rels.*')
            ->get();

        // Find current song position in the collection
        $currentIndex = $songsInPlaylists->search(function ($item) use ($song) {
            return $item->song_code == $song->song_code;
        });

        // Get previous and next songs for navigation
        $previousSong = $currentIndex > 0 ? $songsInPlaylists[$currentIndex - 1] : null;
        $nextSong = $currentIndex < $songsInPlaylists->count() - 1 ? $songsInPlaylists[$currentIndex + 1] : null;

        return view('user.category.alias_song_show', compact(
            'category',
            'song',
            'songsInPlaylists',
            'currentIndex',
            'previousSong',
            'nextSong'
        ));
    }


    public function aliasShow(Request $request, string $code)
    {
        // Get the category
        $category = DB::table('categories')->where('alias', $code)->first();

        if (!$category) {
            abort(404, 'Category not found.');
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                // Query songs only from this specific category
                $query = DB::table('song_cate_rels')
                    ->join('songs', 'song_cate_rels.song_code', '=', 'songs.song_code')
                    ->where('song_cate_rels.category_code', $category->category_code);

                // Search functionality
                if ($request->has('search') && !empty(trim($request->search))) {
                    $keyword = '%' . trim($request->search) . '%';
                    $query->where(function ($q) use ($keyword) {
                        $q->where('songs.title_en', 'LIKE', $keyword)
                            ->orWhere('songs.title_gu', 'LIKE', $keyword)
                            ->orWhere('songs.lyrics_en', 'LIKE', $keyword)
                            ->orWhere('songs.lyrics_gu', 'LIKE', $keyword);
                    });
                }

                $locale = app()->getLocale();

                // Get the songs with pagination
                $songs = $query->orderBy('songs.title_' . $locale, 'asc')
                    ->select('songs.*')
                    ->paginate(30);

                // Transform the songs
                $songsTransformed = $songs->map(function ($song) use ($locale) {
                    $song->title = $song->{'title_' . $locale} ?? $song->title_en;
                    return $song;
                });

                return response()->json([
                    'success' => true,
                    'songs' => $songsTransformed->values(),
                    'locale' => $locale,
                    'pagination' => [
                        'current_page' => $songs->currentPage(),
                        'last_page' => $songs->lastPage(),
                        'per_page' => $songs->perPage(),
                        'total' => $songs->total(),
                        'has_more_pages' => $songs->hasMorePages()
                    ]
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading songs',
                    'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
                ], 500);
            }
        }

        return view('user.category.alias_show', compact('category'));
    }
}

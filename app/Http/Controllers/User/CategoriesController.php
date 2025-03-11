<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SongSubCateRel;
use App\Models\SubCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
      public function index(Request $request)
      {
            if ($request->ajax()) {
                  $data = SubCategory::query(); // Customize your query as needed

                  return DataTables::of($data)
                        ->make(true);
            }
            return view('user.category.index');
      }

      public function show(Request $request, string $code)
      {
            $subCategory = DB::table('sub_categories')->where('sub_category_code', $code)->first();

            if (!$subCategory) {
                  abort(404, 'SubCategory not found.');
            }

            if ($request->ajax()) {
                  $query = DB::table('song_sub_cate_rels')
                        ->where('sub_category_code', $code)
                        ->join('songs', 'songs.song_code', '=', 'song_sub_cate_rels.song_code')
                        ->select('songs.song_code', 'songs.title_en', 'songs.title_gu', 'songs.lyrics_en', 'songs.lyrics_gu');

                  // Add search functionality
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
                  $query->orderBy('songs.title_' . $locale, 'asc');
                  
                  // Paginate the results
                  $songs = $query->paginate(30);
                  
                  // Transform the songs to include the current locale's title as 'title'
                  $songsTransformed = collect($songs->items())->map(function($song) use ($locale) {
                        $song->title = $song->{'title_' . $locale};
                        return $song;
                  });

                  return response()->json([
                        'songs' => $songsTransformed,
                        'locale' => $locale
                  ]);
            }
            return view('user.category.show', compact('subCategory'));
      }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SongsExport;
use App\Models\Configuration;
use App\Models\Playlist;
use Illuminate\Support\Facades\DB;
use App\Models\Song;
use App\Models\SubCategory;

class ExportController extends Controller
{
    public function index()
    {
        $config = Configuration::where('key', 'show_export')->first();
        $exportShow = $config->value;
        if ($exportShow != '1') {
            return redirect()->back()->with('success', 'Page Not Found!');
        }
        $subCategories = SubCategory::all();
        $playlists = Playlist::all();
        return view('admin.exports.index', compact('subCategories', 'playlists'));
    }

    public function export(Request $request)
    {

        // Get the selected subcategories
        $selectedSubcategories = $request->input('subcategories', []);

        $selectedPlaylists = $request->input('playlists', []);

        // Start building the query for songs
        $query = DB::table('songs')
            ->leftJoin('song_sub_cate_rels', 'songs.song_code', '=', 'song_sub_cate_rels.song_code')
            ->leftJoin('sub_categories', 'song_sub_cate_rels.sub_category_code', '=', 'sub_categories.sub_category_code')
            //->leftJoin('playlists', 'songs.playlist_id', '=', 'playlists.id') // Assuming you have a playlist relation
            ->leftJoin('song_playlist_rels', 'songs.song_code', '=', 'song_playlist_rels.song_code')
            ->leftJoin('playlists', 'song_playlist_rels.playlist_code', '=', 'playlists.playlist_code')

            ->leftJoin('cate_sub_cate_rels', 'sub_categories.sub_category_code', '=', 'cate_sub_cate_rels.sub_category_code')
            ->leftJoin('categories', 'cate_sub_cate_rels.category_code', '=', 'categories.category_code')

            ->select(
                'songs.song_code',
                'songs.title_gu',
                'songs.title_en',
                'songs.lyrics_gu',
                'songs.lyrics_en',
                'sub_categories.sub_category_code',
                'sub_categories.sub_category_en',  // The name of the subcategory in English
                'sub_categories.sub_category_gu',  // The name of the subcategory in Gujarati
                'playlists.playlist_code',
                'playlists.playlist_en',
                'playlists.playlist_gu',
                'categories.category_code',
                'categories.category_en',
                'categories.category_gu'
                // 'playlists.playlist_en as playlist_name'  // Assuming playlists have a 'name' field
            );

        // Filter by selected subcategories (if any)
        if (!empty($selectedSubcategories)) {
            $query->whereIn('song_sub_cate_rels.sub_category_code', $selectedSubcategories);
        }

        if (!empty($selectedPlaylists)) {
            $query->whereIn('song_playlist_rels.playlist_code', $selectedPlaylists);
        }

        // Execute the query and get the results
        $songs = $query->get();


        return Excel::download(new SongsExport($songs), 'songs.xlsx');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\SongPlaylistRel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SongsController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Song::query();

        // Apply the search only for the full phrase (Vandu Sahajanand)
        $query->where(function($q) use ($request) {
            $keyword = $request->input('search.value');
            $searchPhrase = '%' . $keyword . '%';

            $q->where('title_en', 'LIKE', $searchPhrase)
              ->orWhere('title_gu', 'LIKE', $searchPhrase)
              ->orWhere('lyrics_en', 'LIKE', $searchPhrase)
              ->orWhere('lyrics_gu', 'LIKE', $searchPhrase);
        });

        // Order by title or any other field as you need
        $query->orderBy('title_' . app()->getLocale(), 'asc'); 

        return DataTables::of($query)
            ->filterColumn('title_' . app()->getLocale(), function ($query, $keyword) {
                // Match exact phrase in the columns
                $sql = "title_en LIKE ? OR title_gu LIKE ? OR lyrics_en LIKE ? OR lyrics_gu LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%", "%{$keyword}%", "%{$keyword}%", "%{$keyword}%"]);
            })
            ->make(true);
    }
    return view('user.songs.index');
}


    public function show(string $songCode)
    {
        // Retrieve the main song
        $song = Song::where('song_code', $songCode)->firstOrFail();

        // Retrieve the playlists for the song
        $playlists = SongPlaylistRel::where('song_code', $songCode)->get();
        $playlistCodes = $playlists->pluck('playlist_code');

        // Get all songs in those playlists, ordered by song_playlist_rels.id in ascending order
        $songsInPlaylists = Song::whereIn('songs.song_code', function ($query) use ($playlistCodes) {
            $query->select('song_code')
                ->from('song_playlist_rels')
                ->whereIn('playlist_code', $playlistCodes);
        })
            // Join song_playlist_rels to access the id column for ordering
            ->join('song_playlist_rels', 'songs.song_code', '=', 'song_playlist_rels.song_code')
            ->orderBy('song_playlist_rels.id', 'asc') // Order by song_playlist_rels.id in ascending order
            ->get();

        // Debugging the retrieved songs (optional)
        // dd($songsInPlaylists->toArray());

        return view('user.songs.show', compact('song', 'songsInPlaylists'));
    }
}

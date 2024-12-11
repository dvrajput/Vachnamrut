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
                  return DataTables::of(Song::select('*'))
                        ->filterColumn('title_'.app()->getLocale(), function($query, $keyword) {
                              $sql = "CONCAT(title_en,' ',title_gu,' ',lyrics_en,' ',lyrics_gu) like ?";
                              $query->whereRaw($sql, ["%{$keyword}%"]);
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

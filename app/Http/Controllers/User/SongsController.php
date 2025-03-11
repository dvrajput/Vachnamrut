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

            if ($request->has('search') && !empty($request->search)) {
                $keyword = '%' . $request->search . '%';
                $query->where('title_en', 'LIKE', $keyword)
                    ->orWhere('title_gu', 'LIKE', $keyword)
                    ->orWhere('lyrics_en', 'LIKE', $keyword)
                    ->orWhere('lyrics_gu', 'LIKE', $keyword);
            }
            $locale = app()->getLocale();
            $songs = $query->orderBy('title_' . $locale, 'asc')
                ->paginate(30);

            // Transform the songs to include the current locale's title as 'title'
            $songsTransformed = $songs->map(function($song) use ($locale) {
                $song->title = $song->{'title_' . $locale};
                return $song;
            });

            return response()->json([
                'songs' => $songsTransformed,
                'locale' => $locale
            ]);
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

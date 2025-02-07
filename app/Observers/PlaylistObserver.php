<?php

namespace App\Observers;

use App\Models\Playlist;
use App\Models\PlaylistLog;
use Illuminate\Support\Facades\Auth;

class PlaylistObserver
{
    /**
     * Handle the Playlist "created" event.
     */
    public function created(Playlist $playlist): void
    {
        PlaylistLog::create([
            'playlist_code' => $playlist->playlist_code,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'changes'    => json_encode($playlist->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Playlist "updated" event.
     */
    public function updated(Playlist $playlist): void
    {
        $changes = $playlist->getChanges();
        PlaylistLog::create([
            'playlist_code' => $playlist->playlist_code,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'changes'    => json_encode($changes),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Playlist "deleted" event.
     */
    public function deleted(Playlist $playlist): void
    {
        PlaylistLog::create([
            'playlist_code'  => $playlist->playlist_code,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'changes'    => json_encode($playlist->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Playlist "restored" event.
     */
    public function restored(Playlist $playlist): void
    {
        PlaylistLog::create([
            'playlist_code'  => $playlist->playlist_code,
            'user_id'    => Auth::id(),
            'action'     => 'restored',
            'changes'    => json_encode($playlist->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Playlist "force deleted" event.
     */
    public function forceDeleted(Playlist $playlist): void
    {
        PlaylistLog::create([
            'playlist_code'  => $playlist->playlist_code,
            'user_id'    => Auth::id(),
            'action'     => 'force_deleted',
            'changes'    => json_encode($playlist->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }
}

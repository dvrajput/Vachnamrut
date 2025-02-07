<?php

namespace App\Observers;

use App\Models\Song;
use App\Models\SongLog;
use Illuminate\Support\Facades\Auth;

class SongObserver
{
    /**
     * Handle the Song "created" event.
     */
    public function created(Song $song): void
    {
        SongLog::create([
            'song_code' => $song->song_code,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'changes'    => json_encode($song->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Song "updated" event.
     */
    public function updated(Song $song): void
    {
        $changes = $song->getChanges();
        SongLog::create([
            'song_code' => $song->song_code,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'changes'    => json_encode($changes),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Song "deleted" event.
     */
    public function deleted(Song $song): void
    {
        SongLog::create([
            'song_code'  => $song->song_code,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'changes'    => json_encode($song->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Song "restored" event.
     */
    public function restored(Song $song): void
    {
        SongLog::create([
            'song_code'  => $song->song_code,
            'user_id'    => Auth::id(),
            'action'     => 'restored',
            'changes'    => json_encode($song->getAttributes()),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Song "force deleted" event.
     */
    public function forceDeleted(Song $song): void
    {
        SongLog::create([
            'song_code'  => $song->song_code,
            'user_id'    => Auth::id(),
            'action'     => 'force_deleted',
            'changes'    => json_encode($song->getOriginal()),
            'ip_address' => request()->ip(),
        ]);
    }
}

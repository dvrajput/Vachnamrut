<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_code',
        'user_id',
        'action',
        'changes',
        'ip_address',
    ];
}

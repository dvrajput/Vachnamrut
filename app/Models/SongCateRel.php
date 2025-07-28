<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongCateRel extends Model
{
    protected $table = 'song_cate_rels';
    
    public $timestamps = false;

    protected $fillable = [
        'song_code',
        'category_code',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_code',
        'category_en',
        'category_gu',
        'alias',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    // public function songs()
    // {
    //     return $this->belongsToMany(Song::class, 'song_category_rels');
    // }
    
}

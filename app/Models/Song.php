<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_code',
        'vachnamrut_code',  // Added this line for the vachnamrut code
        'written_date',  // Added this line for the date field
        'title_en',
        'lyrics_en',
        'title_gu',
        'lyrics_gu',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'song_category_rels');
    // }
    // public function subCategories()
    // {
    //     return $this->belongsToMany(SubCategory::class, 'song_sub_cate_rels');
    // }
    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'song_sub_cate_rels', 'song_code', 'sub_category_code');
    }
}

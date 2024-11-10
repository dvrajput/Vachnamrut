<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SongsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $songs;

    public function __construct($songs)
    {
        $this->songs = $songs;
    }

    public function collection()
    {
        return $this->songs;
    }

    public function headings(): array
    {
        return [
            'Gujarati Title',
            'English Title',
            'Gujarati Lyrics',
            'English Lyrics',
            'English Category',
            'Gujarati Category',
            'English Sub Category',
            'Gujarati Sub Category',
            'English Playlist',
            'Gujarati Playlist',
        ];
    }

    public function map($song): array
    {
        // Here, we manually extract the fields since we're doing a manual join
        return [
            $song->title_gu ?? 'N/A',
            $song->title_en ?? 'N/A',
            $song->lyrics_gu ?? 'N/A',
            $song->lyrics_en ?? 'N/A',
            $song->category_en ?? 'N/A',
            $song->category_gu ?? 'N/A',
            $song->sub_category_en ?? 'N/A',  // Combining English and Gujarati Sub Category
            $song->sub_category_gu ?? 'N/A',  // Combining English and Gujarati Sub Category
            $song->playlist_en  ?? 'N/A',  // If no playlist is associated, use 'N/A'
            $song->playlist_gu ?? 'N/A',  // If no playlist is associated, use 'N/A'
        ];
    }
}

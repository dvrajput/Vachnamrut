<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Song;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('user.contact.create');
    }

    public function create(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $search = $request->get('q', '');
                $locale = app()->getLocale();

                // Build the query
                $query = Song::query()->select(['song_code', 'title_en', 'title_gu']);

                // Apply search if provided
                if (!empty(trim($search))) {
                    $keyword = '%' . trim($search) . '%';
                    $query->where(function ($q) use ($keyword) {
                        $q->where('title_en', 'LIKE', $keyword)
                            ->orWhere('title_gu', 'LIKE', $keyword)
                            ->orWhere('song_code', 'LIKE', $keyword);
                    });
                }

                // Get results with proper ordering
                $songs = $query->orderBy('title_' . $locale, 'asc')
                    ->limit(20) // Increased limit for better UX
                    ->get();

                // Transform data for Select2
                $results = $songs->map(function ($song) use ($locale) {
                    $title = $locale === 'gu' && $song->title_gu
                        ? $song->title_gu
                        : $song->title_en;

                    return [
                        'id' => $song->song_code,
                        'text' => $title ?: $song->song_code,
                        'title_en' => $song->title_en,
                        'title_gu' => $song->title_gu
                    ];
                });

                return response()->json([
                    'results' => $results,
                    'pagination' => [
                        'more' => false // You can implement pagination later if needed
                    ],
                    'success' => true
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'results' => [],
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading songs',
                    'success' => false
                ], 500);
            }
        }

        return view('user.contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'message' => 'required|string|max:255',
            'song_code' => 'nullable|exists:songs,song_code'
        ]);

        // Create the new contact record
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'song_code' => $request->song_code
        ]);

        $url = "https://api.telegram.org/bot8033660943:AAEyvbadTsoO_NCDwgcDfcW3jgm2h9bM9rE/sendMessage";
        // dd($url);

        $kirtan = Song::where('song_code', $request->song_code)->first();
        // Check if song_code exists and get kirtan name
        $name = "No kirtan selected";
        if ($request->song_code) {
            $kirtan = Song::where('song_code', $request->song_code)->first();
            if ($kirtan) {
                $name = $kirtan->title_gu ?? $kirtan->title_en;
            }
        }
        $v = Http::post($url, [
            'chat_id' => -1002252561130,
            'text' => "kirtan id :{$request->song_code}\n" .
                "kirtan name: {$name}\n" .
                "name: {$request->name}\n" .
                "email: {$request->email}\n" .
                "message: {$request->message}",
            'parse_mode' => 'HTML'
        ]);
        Log::info($v->body());

        return redirect()->route('user.contact.create')->with('success', 'Thanks for suggesting!');
    }

    public function edit(Request $request, $song_code)
    {
        $song = Song::select('id', 'song_code', 'title_en', 'lyrics_en', 'title_gu', 'lyrics_gu')->where('song_code', $song_code)->first();
        return view('user.contact.edit', compact('song'));
    }
}

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
    public function index(){
        return view('user.contact.create');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('q', ''); // Get the search query if provided
            $locale = app()->getLocale(); // Get current locale
            
            $query = Song::query()->select('song_code', 'title_en', 'title_gu');
            
            if (!empty($search)) {
                $keyword = '%' . $search . '%';
                $query->where('title_en', 'LIKE', $keyword)
                    ->orWhere('title_gu', 'LIKE', $keyword)
                    ->orWhere('song_code', 'LIKE', $keyword); // Add search by song_code
            }
            
            $songs = $query->orderBy('title_' . $locale, 'asc')
                ->limit(10)
                ->get();
            
            return response()->json($songs);
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

$kirtan=Song::where('song_code',$request->song_code)->first();
$name=$kirtan->title_gu ?? $kirtan->title_en;
        $v= Http::post($url, [
            'chat_id' => -1002252561130,
            'text' => "kirtan id :{$request->song_code}\n".
            "kirtan name: {$name}\n".
            "name: {$request->name}\n".
            "email: {$request->email}\n".
            "message: {$request->message}",
            'parse_mode' => 'HTML'
        ]);
        Log::info($v->body());

        return redirect()->route('user.contact.create')->with('success', 'Thanks for suggesting!');
    }

    public function edit(Request $request, $song_code)
    {
        $song = Song::select('id','song_code','title_en','lyrics_en','title_gu','lyrics_gu')->where('song_code', $song_code)->first();
        return view('user.contact.edit', compact('song'));
    }
}

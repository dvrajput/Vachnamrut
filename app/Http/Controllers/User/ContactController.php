<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Song;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('q', ''); // Get the search query if provided

            $songs = Song::select('song_code', 'title_en')
                ->where('title_en', 'like', '%' . $search . '%') // Optional: search songs by title
                ->limit(10) // Limit results to 10 (you can adjust this based on your preference)
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

        return redirect()->route('user.contact.create')->with('success', 'Thanks for suggesting!');
    }
}

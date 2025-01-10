<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Contact;
use App\Models\Song;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $config = Configuration::where('key', 'show_contact')->first();
        $contactShow = $config->value;
        if ($contactShow != '1') {
            return redirect()->route('admin.songs.index')->with('success', 'Page Not Found!');
        }

        if ($request->ajax()) {
            $data = Contact::orderBy('id', 'desc'); // Customize your query as needed

            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.contacts.index');
    }

    public function edit(string $id)
    {
        $contact = Contact::where('id', $id)->firstOrFail();

        $songs = Song::where('song_code', $contact->song_code) // Change here to use playlist_code
            ->first();

        return view('admin.contacts.edit', compact('contact', 'songs'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'message' => 'required|string|max:255',
            'status' => 'required'
        ]);

        // Find the song by song_code
        $conatact = Contact::where('id', $id)->firstOrFail();

        // Update song details
        $conatact->update([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => $request->status
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Query updated successfully!');
    }

    public function destroy(string $id)
    {
        $contact = Contact::where('id', $id)->firstOrFail();

        // Delete contact
        $contact->delete();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Query deleted successfully');
    }
}

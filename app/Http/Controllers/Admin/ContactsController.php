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

    public function approve(Request $request, $id)
{
    $contact = Contact::findOrFail($id);
    $contact->status = 1; // Approved
    $contact->save();
    
    // Check if we should send a thank you email
    if ($request->send_thanks) {
        $this->sendThankYouEmail($contact);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Contact approved successfully.'
    ]);
}

    public function reject(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = 2; // Rejected
        $contact->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Contact rejected successfully.'
        ]);
    }

    public function sendThankYouEmail($contact)
    {
        // Get song name if song code exists
        $songName = '';
        if ($contact->song_code) {
            $song = Song::where('song_code', $contact->song_code)->first();
            if ($song) {
                $songName = $song->title_gu;
            }
        }
        
        // Send email
        \Illuminate\Support\Facades\Mail::to($contact->email)->send(new \App\Mail\ThankYouMail($contact->name, $songName));
        
        return true;
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No contacts selected.'
            ]);
        }
        
        Contact::whereIn('id', $ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => count($ids) . ' queries deleted successfully.'
        ]);
    }

    public function deleteAll(Request $request)
    {
        // Check if user is owner
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action.'
            ]);
        }
        
        $count = Contact::count();
        Contact::truncate();
        
        return response()->json([
            'success' => true,
            'message' => 'All ' . $count . ' queries deleted successfully.'
        ]);
    }
}

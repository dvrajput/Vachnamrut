<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\Song;
use App\Models\SongCateRel;
use App\Models\SongSubCateRel;
use App\Models\SubCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // $songs = Song::paginate(10);
    //     $songs = Song::all();
    //     return view('admin.songs.index', compact('songs'));
    //     // return view('admin.songs.index', compact('songs'));
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Song::orderBy('id', 'asc'); // Customize your query as needed

            return DataTables::of($data)
                // ->addColumn('action', function ($row) {
                //     $editButton = '<a href="' . route('admin.songs.edit', $row->id) . '" class="btn btn-warning btn-sm ml-2">Edit</a>';
                //     $viewButton = '<a href="' . route('admin.songs.show', $row->id) . '" class="btn btn-info btn-sm">View</a>';

                //     // Delete button with form
                //     $deleteButton = '
                //     <form action="' . route('admin.songs.destroy', $row->id) . '" method="POST" style="display:inline-block;" class="delete-form">
                //         ' . csrf_field() . '
                //         ' . method_field('DELETE') . '
                //         <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this song?\')">Delete</button>
                //     </form>
                // ';

                //     return $viewButton . $editButton . $deleteButton;
                // })
                ->make(true);
        }
        $config = Configuration::where('key', 'song_delete')->first();
        $deleteBtn = $config->value ?? 0;

        $config = Configuration::where('key', 'song_create')->first();
        $createBtnShow = $config->value ?? 0;

        return view('admin.songs.index', compact('deleteBtn','createBtnShow'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.songs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'written_date' => 'nullable|string|max:50', // Added validation for written_date
            'title_en' => 'nullable|string|max:255',
            'lyrics_en' => 'nullable|string',
            'title_gu' => 'nullable|string|max:255',
            'lyrics_gu' => 'nullable|string',
            'sub_category_code' => 'nullable|array',
            'sub_category_code.*' => 'exists:sub_categories,sub_category_code',
        ]);

        // Get song prefix from the configuration table
        $config = Configuration::where('key', 'song_prefix')->value('value');

        // Find the last song with the same prefix
        $lastSong = Song::where('song_code', 'LIKE', "$config%")
            ->orderBy('id', 'desc')
            ->first();

        // Determine the new song code
        if ($lastSong) {
            // Extract the numeric part and increment it
            $lastNumber = intval(substr($lastSong->song_code, strlen($config)));
            $newSongCode = $config . ($lastNumber + 1);
        } else {
            // No song exists with this prefix; start with the prefix followed by 1
            $newSongCode = $config . '1';
        }

        // Create the new song record
        $song = Song::create([
            'song_code' => $request->song_code,
            'written_date' => $request->written_date, // Added written_date field
            'title_en' => $request->title_en??'',
            'lyrics_en' => $request->lyrics_en??'',
            'title_gu' => $request->title_gu,
            'lyrics_gu' => $request->lyrics_gu,
        ]);

        // Handle subcategories if provided
        if ($request->filled('category_code')) {
            foreach ($request->category_code as $categoryCode) {
                SongCateRel::create([
                    'song_code' => $song->song_code,
                    'category_code' => $categoryCode,
                ]);
            }
        }

        return redirect()->route('admin.songs.index')->with('success', 'Song added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $song_code)
    {
        $song = Song::where('song_code', $song_code)->firstOrFail();
        return view('admin.songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $song_code)
    {
        // dd($song_code);
        $song = Song::where('song_code', $song_code)->firstOrFail();
        // dump($song->toArray());
        // $song = Song::findOrFail($song_code);

        $subCategories = SubCategory::select('sub_categories.*')
            ->join('song_sub_cate_rels', 'sub_categories.sub_category_code', '=', 'song_sub_cate_rels.sub_category_code')
            ->where('song_sub_cate_rels.song_code', $song_code)
            ->get();

        // $subCategories = SubCategory::all();
        $allSubCategories = SubCategory::all();
        // dd($subCategories->toArray());
        // Pass the song data to the edit view
        return view('admin.songs.edit', compact('song', 'allSubCategories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $song_code)
    {
        $request->validate([
            'written_date' => 'nullable|string|max:50', // Added validation for written_date
            'title_en' => 'nullable|string|max:255',
            'lyrics_en' => 'nullable|string',
            'title_gu' => 'nullable|string|max:255',
            'lyrics_gu' => 'nullable|string',
            'sub_category_code' => 'nullable|array', // Ensure categories are passed as an array
            'sub_category_code.*' => 'exists:sub_categories,sub_category_code', // Each category must exist in the categories table
        ]);

        // Find the song by song_code
        $song = Song::where('song_code', $song_code)->firstOrFail();

        // Update song details
        $song->update([
            'written_date' => $request->written_date, // Added written_date field
            'title_en' => $request->title_en??"",
            'lyrics_en' => $request->lyrics_en??"",
            'title_gu' => $request->title_gu,
            'lyrics_gu' => $request->lyrics_gu,
        ]);

        // Get current subcategories associated with the song
        $currentSubCategories = DB::table('song_sub_cate_rels')
            ->where('song_code', $song_code)
            ->pluck('sub_category_code')
            ->toArray();

        // Check if sub_category_code is present in the request
        if ($request->has('sub_category_code')) {
            $subCategoriesToAdd = array_diff($request->sub_category_code, $currentSubCategories);
            $subCategoriesToRemove = array_diff($currentSubCategories, $request->sub_category_code);

            // Add new subcategories
            foreach ($subCategoriesToAdd as $subCategoryCode) {
                DB::table('song_sub_cate_rels')->insert([
                    'song_code' => $song->song_code,
                    'sub_category_code' => $subCategoryCode,
                ]);
            }

            // Remove unselected subcategories
            foreach ($subCategoriesToRemove as $subCategoryCode) {
                DB::table('song_sub_cate_rels')->where('song_code', $song->song_code)
                    ->where('sub_category_code', $subCategoryCode)
                    ->delete();
            }
        } else {
            // If sub_category_code is null, remove all subcategories
            DB::table('song_sub_cate_rels')->where('song_code', $song->song_code)->delete();
        }

        return redirect()->route('admin.songs.index')->with('success', 'Song updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $song_code)
    {
        // Find the song by song_code
        $song = Song::where('song_code', $song_code)->firstOrFail();

        // Delete the associated subcategories
        DB::table('song_sub_cate_rels')
            ->where('song_code', $song_code)
            ->delete();

        // Delete the song
        $song->delete();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Song deleted successfully');
    }

    public function changeLanguage($locale)
    {
        Session::put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}

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
use Illuminate\Validation\Rule;

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
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = Song::query();

                // Handle DataTables parameters
                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                // Apply search if provided
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('song_code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('title_en', 'LIKE', "%{$searchValue}%")
                            ->orWhere('title_gu', 'LIKE', "%{$searchValue}%")
                            ->orWhere('lyrics_en', 'LIKE', "%{$searchValue}%")
                            ->orWhere('lyrics_gu', 'LIKE', "%{$searchValue}%");
                    });
                }

                // Handle ordering
                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'asc';
                $columns = ['song_code', 'title_en', 'lyrics_en', 'title_gu', 'lyrics_gu', 'action'];

                if (isset($columns[$orderColumn]) && $columns[$orderColumn] !== 'action') {
                    $query->orderBy($columns[$orderColumn], $orderDir);
                } else {
                    $query->orderBy('id', 'asc');
                }

                // Get total records
                $totalRecords = Song::count();
                $filteredRecords = $query->count();

                // Get paginated results
                $songs = $query->skip($start)->take($length)->get();

                // Transform data for DataTables
                $data = $songs->map(function ($song) {
                    return [
                        'song_code' => $song->song_code,
                        'title_en' => $song->title_en,
                        'lyrics_en' => $song->lyrics_en,
                        'title_gu' => $song->title_gu,
                        'lyrics_gu' => $song->lyrics_gu,
                        'action' => $song // Pass the whole object for action rendering
                    ];
                });

                return response()->json([
                    'draw' => intval($request->get('draw')),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data,
                    'success' => true
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'draw' => intval($request->get('draw', 0)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading songs',
                    'success' => false
                ], 500);
            }
        }

        $config = Configuration::where('key', 'song_delete')->first();
        $deleteBtn = $config->value ?? 0;

        $config = Configuration::where('key', 'song_create')->first();
        $createBtnShow = $config->value ?? 0;

        return view('admin.songs.index', compact('deleteBtn', 'createBtnShow'));
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
            'song_code' => 'required|unique:songs,song_code',
            'vachnamrut_code' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->filled('category_code')) {
                        $exists = DB::table('songs')
                            ->join('song_cate_rels', 'songs.song_code', '=', 'song_cate_rels.song_code')
                            ->where('song_cate_rels.category_code', $request->category_code)
                            ->where('songs.vachnamrut_code', $value)
                            ->exists();

                        if ($exists) {
                            $fail("The {$attribute} '{$value}' already exists in this category.");
                        }
                    }
                },
            ],
            'written_date' => 'nullable|string|max:50',
            'title_en' => 'nullable|string|max:255',
            'lyrics_en' => 'nullable|string',
            'title_gu' => 'nullable|string|max:255',
            'lyrics_gu' => 'nullable|string',
        ]);

        // Get song prefix from the configuration table
        $config = Configuration::where('key', 'song_prefix')->value('value');

        // Find the last song with the same prefix
        $lastSong = Song::where('song_code', 'LIKE', "$config%")
            ->orderBy('id', 'desc')
            ->first();

        // Determine the new song code
        if ($lastSong) {
            $lastNumber = intval(substr($lastSong->song_code, strlen($config)));
            $newSongCode = $config . ($lastNumber + 1);
        } else {
            $newSongCode = $config . '1';
        }

        // Create the new song record (✅ vachnamrut_code saved in songs)
        $song = Song::create([
            'song_code' => $request->song_code,
            'vachnamrut_code' => $request->vachnamrut_code,
            'written_date' => $request->written_date,
            'title_en' => $request->title_en ?? '',
            'lyrics_en' => $request->lyrics_en ?? '',
            'title_gu' => $request->title_gu,
            'lyrics_gu' => $request->lyrics_gu,
        ]);

        // Save category relation
        if ($request->filled('category_code')) {
            SongCateRel::create([
                'song_code' => $song->song_code,
                'category_code' => $request->category_code,
            ]);
        }

        return redirect()->route('admin.songs.index')->with('success', 'Vachnamrut added successfully!');
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
            'title_en' => $request->title_en ?? "",
            'lyrics_en' => $request->lyrics_en ?? "",
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

        return redirect()->route('admin.songs.index')->with('success', 'Vachnamrut updated successfully!');
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
        return redirect()->back()->with('success', 'Vachnamrut deleted successfully');
    }

    public function changeLanguage($locale)
    {
        Session::put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}

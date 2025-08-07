<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CateSubCateRel;
use App\Models\Configuration;
use App\Models\SongCateRel;
use App\Models\Song;
use App\Models\SongCategoryRel;
use App\Models\SubCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        try {
            $query = Category::query();

            // Handle DataTables parameters
            $start = $request->get('start', 0);
            $length = $request->get('length', 25);
            $searchValue = $request->get('search')['value'] ?? '';
            
            // Apply search if provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('category_code', 'LIKE', "%{$searchValue}%")
                      ->orWhere('category_en', 'LIKE', "%{$searchValue}%")
                      ->orWhere('category_gu', 'LIKE', "%{$searchValue}%")
                      ->orWhere('alias', 'LIKE', "%{$searchValue}%");
                });
            }

            // Handle ordering
            $orderColumn = $request->get('order')[0]['column'] ?? 0;
            $orderDir = $request->get('order')[0]['dir'] ?? 'asc';
            $columns = ['category_code', 'category_en', 'category_gu', 'action'];
            
            if (isset($columns[$orderColumn]) && $columns[$orderColumn] !== 'action') {
                $query->orderBy($columns[$orderColumn], $orderDir);
            } else {
                $query->orderBy('category_code', 'asc');
            }

            // Get total records
            $totalRecords = Category::count();
            $filteredRecords = $query->count();

            // Get paginated results
            $categories = $query->skip($start)->take($length)->get();

            // Transform data for DataTables
            $data = $categories->map(function ($category) {
                return [
                    'category_code' => $category->category_code,
                    'category_en' => $category->category_en,
                    'category_gu' => $category->category_gu,
                    'alias' => $category->alias,
                    'action' => $category // Pass the whole object for action rendering
                ];
            });

            return response()->json([
                'draw' => intval($request->get('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
                'success' => true
            ]);

        } catch (Exception $e) {
            return response()->json([
                'draw' => intval($request->get('draw', 0)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => config('app.debug') ? $e->getMessage() : 'Error loading categories',
                'success' => false
            ], 500);
        }
    }

    $config = Configuration::where('key', 'category_delete')->first();
    $deleteBtn = $config->value ?? 0;
    
    $config = Configuration::where('key', 'category_create')->first();
    $createBtnShow = $config->value ?? 0;

    return view('admin.category.index', compact('deleteBtn', 'createBtnShow'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_en' => 'required|string',
            'category_gu' => 'required|string',
            'alias' => 'required|string',
        ]);

        //get category prefix from configuraton table
        $config = Configuration::where('key', 'category_prefix')->value('value');
        // dd($config);
        // Find the last category with the same prefix
        $lastCategory = Category::where('category_code', 'LIKE', "$config%")
            ->orderBy('id', 'desc')
            ->first();

        // Determine the new category code
        if ($lastCategory) {
            // Extract the numeric part and increment it
            $lastNumber = intval(substr($lastCategory->category_code, strlen($config)));
            $newCategoryCode = $config . ($lastNumber + 1);
        } else {
            // No category exists with this prefix, start with the prefix followed by 1
            $newCategoryCode = $config . '1';
        }

        Category::create([
            'category_code' => $newCategoryCode,
            'category_en' => $request->category_en,
            'category_gu' => $request->category_gu,
            'alias' => $request->alias,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $category_code)
    {
        // $category = Category::findOrFail($category_code);
        $category = Category::where('category_code', $category_code)->firstOrFail();

        if ($request->ajax()) {
            $data = SongCateRel::where('category_code', $category_code)
                ->join('songs', 'songs.song_code', '=', 'song_cate_rels.song_code')
                ->select('songs.song_code', 'songs.title_en') // Adjust fields as needed
                ->get();
            
            return DataTables::of($data)
                ->make(true);
        }
        
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $category_code)
    {
        $category = Category::where('category_code', $category_code)->firstOrFail();

        // Pass the category data to the edit view
        return view('admin.category.edit', compact('category'));
    }

    public function fetchAssociatedSongs(Request $request, string $category_code)
    {
        $data = SongCategoryRel::where('category_code', $category_code)
            ->join('songs', 'songs.song_code', '=', 'song_category_rels.song_code')
            ->select('songs.song_code', 'songs.title_en');
        
        return DataTables::of($data)->make(true);
    }

    public function fetchRemainingSongs(Request $request, string $category_code)
    {
        $data = Song::whereNotIn('song_code', function ($query) use ($category_code) {
            $query->select('song_code')
                ->from('song_category_rels')
                ->where('category_code', $category_code);
        })->select('song_code', 'title_en');

        return DataTables::of($data)->make(true);
    }

    public function addSongToCategory(Request $request)
    {
        $request->validate([
            'song_code' => 'required|exists:songs,song_code',
            'category_code' => 'required|exists:categories,category_code',
        ]);

        // Create the relationship
        SongCategoryRel::create([
            'song_code' => $request->song_code,
            'category_code' => $request->category_code,
        ]);

        return redirect()->back()->with('success', 'Song added to category successfully');
    }

    public function removeSongFromCategory(Request $request, $song_code)
    {
        $relationship = SongCategoryRel::where('song_code', $song_code)
            ->where('category_code', $request->category_code)
            ->first();
        
        if ($relationship) {
            $relationship->delete();
            return redirect()->back()->with('success', 'Song removed from category successfully');
        }

        return redirect()->back()->with('error', 'Song not found in this category');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $category_code)
    {
        $request->validate([
            'category_en' => 'required|string',
            'category_gu' => 'required|string'
        ]);

        $category = Category::where('category_code', $category_code)->firstOrFail();

        $category->update([
            'category_en' => $request->category_en,
            'category_gu' => $request->category_gu
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category_code)
    {
        $category = Category::where('category_code', $category_code)->firstOrFail();
        
        $subCategories = CateSubCateRel::where('category_code', $category_code)->pluck('sub_category_code');

        if ($subCategories->isNotEmpty()) {
            SubCategory::whereIn('sub_category_code', $subCategories)->delete();
        }

        // Delete the categories
        $category->delete();

        // Return a response indicating success
        return redirect()->back()->with(['success' => 'Category deleted successfully']);
    }
}

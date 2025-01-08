<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Song;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getSongs()
    {
        $songs = Song::all();
        return response()->json([
            'status' => 'success',
            'data' => $songs
        ]);
    }

    public function getSubCategory()
    {
        $subCategory = SubCategory::all();
        return response()->json([
            'status' => 'success',
            'data' => $subCategory
        ]);
    }

    public function getCategory()
    {
        $category = Category::all();
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }
}

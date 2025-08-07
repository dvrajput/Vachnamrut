<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = Configuration::query();

                // Handle DataTables parameters
                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                // Apply search if provided
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('key', 'LIKE', "%{$searchValue}%")
                            ->orWhere('value', 'LIKE', "%{$searchValue}%")
                            ->orWhere('message', 'LIKE', "%{$searchValue}%")
                            ->orWhere('id', 'LIKE', "%{$searchValue}%");
                    });
                }

                // Handle ordering
                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'asc';
                $columns = ['id', 'key', 'value', 'message', 'action'];

                if (isset($columns[$orderColumn]) && $columns[$orderColumn] !== 'action') {
                    $query->orderBy($columns[$orderColumn], $orderDir);
                } else {
                    $query->orderBy('id', 'asc');
                }

                // Get total records
                $totalRecords = Configuration::count();
                $filteredRecords = $query->count();

                // Get paginated results
                $configurations = $query->skip($start)->take($length)->get();

                // Transform data for DataTables
                $data = $configurations->map(function ($config) {
                    return [
                        'id' => $config->id,
                        'key' => $config->key,
                        'value' => $config->value,
                        'message' => $config->message,
                        'created_at' => $config->created_at,
                        'updated_at' => $config->updated_at,
                        'action' => $config // Pass the whole object for action rendering
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
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading configurations',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.config.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'message' => 'nullable|string|max:255'
        ]);

        // Create the new config record
        Configuration::create([
            'key' => $request->key,
            'value' => $request->value,
            'message' => $request->message
        ]);

        return redirect()->route('admin.config.index')->with('success', 'Config added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $config = Configuration::where('id', $id)->firstOrFail();

        return view('admin.config.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'message' => 'nullable|string|max:255'
        ]);

        // Find the config by id
        $config = Configuration::where('id', $id)->firstOrFail();

        // Update config details
        $config->update([
            'key' => $request->key,
            'value' => $request->value,
            'message' => $request->message
        ]);


        return redirect()->route('admin.config.index')->with('success', 'Config updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the config by id
        $config = Configuration::where('id', $id)->firstOrFail();

        // Delete the config
        $config->delete();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Config deleted successfully');
    }
}

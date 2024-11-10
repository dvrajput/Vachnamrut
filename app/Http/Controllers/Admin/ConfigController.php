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
        if ($request->ajax()) {
            $data = Configuration::orderBy('id', 'asc'); // Customize your query as needed

            return DataTables::of($data)

                ->make(true);
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

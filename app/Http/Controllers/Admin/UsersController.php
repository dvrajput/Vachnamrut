<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        // dd(Auth::id());

        $user = User::where('id', Auth::id())->first();

        $createBtnShow = 0;
        // dd($user->role);
        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $data = User::orderBy('id', 'asc'); // Customize your query as needed

                return DataTables::of($data)
                    ->make(true);
            }
            $createBtnShow = 1;
        } else {
            if ($request->ajax()) {
                $data = User::where('id', Auth::id())->orderBy('id', 'asc'); // Customize your query as needed

                return DataTables::of($data)
                    ->make(true);
            }
            $createBtnShow = 0;
        }

        return view('admin.users.index', compact('createBtnShow'));
    }

    public function create()
    {
        $user = User::where('id', Auth::id())->first();

        if ($user->role == 'admin') {
            return view('admin.users.create');
        } else {
            // return response()->view('errors.404', [], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User added successfully!');
    }

    public function edit(int $id)
    {
        $auth = User::where('id', Auth::id())->first();
        if ($auth->role == 'admin') {
            $user = User::where('id', $id)->firstOrFail();
            return view('admin.users.edit', compact('user'));
        } else {
            // return response()->view('errors.404', [], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('id', $id)->firstOrFail();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function show(int $id)
    {
        // return response()->view('errors.404', [], 404);
    }

    public function destroy(int $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}

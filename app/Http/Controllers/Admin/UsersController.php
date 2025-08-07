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
        try {
            $user = Auth::user();

            if (!$user) {
                if ($request->ajax()) {
                    return response()->json([
                        'draw' => intval($request->get('draw', 0)),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                        'error' => 'User not authenticated',
                        'success' => false
                    ], 401);
                }
                return redirect()->route('login');
            }

            $isAdmin = $user->role === 'admin';
            $createBtnShow = $isAdmin ? 1 : 0;

            if ($request->ajax() || $request->wantsJson()) {
                try {
                    // Build query based on user role
                    $query = $isAdmin ? User::query() : User::where('id', $user->id);

                    // Handle DataTables parameters
                    $start = $request->get('start', 0);
                    $length = $request->get('length', 25);
                    $searchValue = $request->get('search')['value'] ?? '';

                    // Apply search if provided
                    if (!empty($searchValue)) {
                        $query->where(function ($q) use ($searchValue) {
                            $q->where('name', 'LIKE', "%{$searchValue}%")
                                ->orWhere('email', 'LIKE', "%{$searchValue}%")
                                ->orWhere('role', 'LIKE', "%{$searchValue}%");
                        });
                    }

                    // Handle ordering
                    $orderColumn = $request->get('order')[0]['column'] ?? 0;
                    $orderDir = $request->get('order')[0]['dir'] ?? 'asc';
                    $columns = ['name', 'email', 'role', 'action'];

                    if (isset($columns[$orderColumn]) && $columns[$orderColumn] !== 'action') {
                        $query->orderBy($columns[$orderColumn], $orderDir);
                    } else {
                        $query->orderBy('id', 'asc');
                    }

                    // Get total records (based on user role)
                    $totalRecords = $isAdmin ? User::count() : 1;
                    $filteredRecords = $query->count();

                    // Get paginated results
                    $users = $query->skip($start)->take($length)->get();

                    // Transform data for DataTables
                    $data = $users->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'role' => $user->role,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                            'action' => $user // Pass the whole object for action rendering
                        ];
                    });

                    return response()->json([
                        'draw' => intval($request->get('draw')),
                        'recordsTotal' => $totalRecords,
                        'recordsFiltered' => $filteredRecords,
                        'data' => $data,
                        'success' => true,
                        'isAdmin' => $isAdmin
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'draw' => intval($request->get('draw', 0)),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                        'error' => config('app.debug') ? $e->getMessage() : 'Error loading users',
                        'success' => false
                    ], 500);
                }
            }

            return view('admin.users.index', compact('createBtnShow'));
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'draw' => intval($request->get('draw', 0)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Server error',
                    'success' => false
                ], 500);
            }
            abort(500, 'Server error');
        }
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

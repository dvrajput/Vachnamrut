<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function index()
    {
        return view('admin.logs.index');
    }

    public function getLogs(Request $request)
    {
        // Check admin permissions
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            if ($request->ajax()) {
                return response()->json([
                    'draw' => intval($request->get('draw', 0)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Access denied',
                    'success' => false
                ], 403);
            }
            abort(403, 'Access denied');
        }

        if ($request->ajax() || $request->wantsJson()) {
            $type = $request->get('type', 'song');

            try {
                switch ($type) {
                    case 'categories':
                        return $this->getCategoryLogs($request);
                    case 'subcategories':
                        return $this->getSubcategoryLogs($request);
                    case 'playlists':
                        return $this->getPlaylistLogs($request);
                    default:
                        return $this->getSongLogs($request);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'draw' => intval($request->get('draw', 0)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading logs',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.logs.index');
    }

    public function getSongLogs(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                // Build the query
                $query = DB::table('song_logs')
                    ->leftJoin('users', 'song_logs.user_id', '=', 'users.id')
                    ->select([
                        'song_logs.id',
                        'song_logs.song_code as code',
                        'users.name as user_name',
                        'song_logs.changes',
                        'song_logs.action',
                        'song_logs.created_at'
                    ]);

                // Handle DataTables parameters
                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                // Apply search if provided
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('song_logs.song_code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('users.name', 'LIKE', "%{$searchValue}%")
                            ->orWhere('song_logs.action', 'LIKE', "%{$searchValue}%")
                            ->orWhereRaw("DATE_FORMAT(song_logs.created_at,'%d-%m-%Y %H:%i:%s') LIKE ?", ["%{$searchValue}%"]);
                    });
                }

                // Handle ordering
                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'desc';
                $columns = ['id', 'song_code', 'user_name', 'action', 'changes', 'created_at'];

                if (isset($columns[$orderColumn])) {
                    $orderField = $columns[$orderColumn] === 'user_name' ? 'users.name' : 'song_logs.' . $columns[$orderColumn];
                    if ($columns[$orderColumn] === 'song_code') {
                        $orderField = 'song_logs.song_code';
                    }
                    $query->orderBy($orderField, $orderDir);
                } else {
                    $query->orderBy('song_logs.id', 'desc');
                }

                // Get total records
                $totalRecords = DB::table('song_logs')->count();
                $filteredRecords = $query->count();

                // Get paginated results
                $logs = $query->skip($start)->take($length)->get();

                // Transform data for DataTables
                $data = $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'code' => $log->code,
                        'user_name' => $log->user_name ?? 'N/A',
                        'action' => $log->action,
                        'changes' => $this->formatChanges($log->changes),
                        'created_at' => date('d-m-Y H:i:s', strtotime($log->created_at)),
                        'raw_changes' => $log->changes
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
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading song logs',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.logs.index');
    }

    public function getCategoryLogs(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = DB::table('category_logs')
                    ->leftJoin('users', 'category_logs.user_id', '=', 'users.id')
                    ->select([
                        'category_logs.id',
                        'category_logs.category_code as code',
                        'users.name as user_name',
                        'category_logs.changes',
                        'category_logs.action',
                        'category_logs.created_at'
                    ]);

                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('category_logs.category_code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('users.name', 'LIKE', "%{$searchValue}%")
                            ->orWhere('category_logs.action', 'LIKE', "%{$searchValue}%")
                            ->orWhereRaw("DATE_FORMAT(category_logs.created_at,'%d-%m-%Y %H:%i:%s') LIKE ?", ["%{$searchValue}%"]);
                    });
                }

                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'desc';
                $columns = ['id', 'category_code', 'user_name', 'action', 'changes', 'created_at'];

                if (isset($columns[$orderColumn])) {
                    $orderField = $columns[$orderColumn] === 'user_name' ? 'users.name' : 'category_logs.' . $columns[$orderColumn];
                    if ($columns[$orderColumn] === 'category_code') {
                        $orderField = 'category_logs.category_code';
                    }
                    $query->orderBy($orderField, $orderDir);
                } else {
                    $query->orderBy('category_logs.id', 'desc');
                }

                $totalRecords = DB::table('category_logs')->count();
                $filteredRecords = $query->count();
                $logs = $query->skip($start)->take($length)->get();

                $data = $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'code' => $log->code,
                        'user_name' => $log->user_name ?? 'N/A',
                        'action' => $log->action,
                        'changes' => $this->formatChanges($log->changes, ['updated_at', 'id', 'created_at', 'playlist_code']),
                        'created_at' => date('d-m-Y H:i:s', strtotime($log->created_at)),
                        'raw_changes' => $log->changes
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
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading category logs',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.logs.index');
    }

    public function getSubcategoryLogs(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = DB::table('sub_category_logs')
                    ->leftJoin('users', 'sub_category_logs.user_id', '=', 'users.id')
                    ->select([
                        'sub_category_logs.id',
                        'sub_category_logs.sub_category_code as code',
                        'users.name as user_name',
                        'sub_category_logs.changes',
                        'sub_category_logs.action',
                        'sub_category_logs.created_at'
                    ]);

                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('sub_category_logs.sub_category_code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('users.name', 'LIKE', "%{$searchValue}%")
                            ->orWhere('sub_category_logs.action', 'LIKE', "%{$searchValue}%")
                            ->orWhereRaw("DATE_FORMAT(sub_category_logs.created_at,'%d-%m-%Y %H:%i:%s') LIKE ?", ["%{$searchValue}%"]);
                    });
                }

                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'desc';
                $columns = ['id', 'sub_category_code', 'user_name', 'action', 'changes', 'created_at'];

                if (isset($columns[$orderColumn])) {
                    $orderField = $columns[$orderColumn] === 'user_name' ? 'users.name' : 'sub_category_logs.' . $columns[$orderColumn];
                    if ($columns[$orderColumn] === 'sub_category_code') {
                        $orderField = 'sub_category_logs.sub_category_code';
                    }
                    $query->orderBy($orderField, $orderDir);
                } else {
                    $query->orderBy('sub_category_logs.id', 'desc');
                }

                $totalRecords = DB::table('sub_category_logs')->count();
                $filteredRecords = $query->count();
                $logs = $query->skip($start)->take($length)->get();

                $data = $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'code' => $log->code,
                        'user_name' => $log->user_name ?? 'N/A',
                        'action' => $log->action,
                        'changes' => $this->formatChanges($log->changes, ['updated_at', 'id', 'created_at', 'playlist_code', 'sub_category_code']),
                        'created_at' => date('d-m-Y H:i:s', strtotime($log->created_at)),
                        'raw_changes' => $log->changes
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
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading subcategory logs',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.logs.index');
    }

    public function getPlaylistLogs(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = DB::table('playlist_logs')
                    ->leftJoin('users', 'playlist_logs.user_id', '=', 'users.id')
                    ->select([
                        'playlist_logs.id',
                        'playlist_logs.playlist_code as code',
                        'users.name as user_name',
                        'playlist_logs.changes',
                        'playlist_logs.action',
                        'playlist_logs.created_at'
                    ]);

                $start = $request->get('start', 0);
                $length = $request->get('length', 25);
                $searchValue = $request->get('search')['value'] ?? '';

                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('playlist_logs.playlist_code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('users.name', 'LIKE', "%{$searchValue}%")
                            ->orWhere('playlist_logs.action', 'LIKE', "%{$searchValue}%")
                            ->orWhereRaw("DATE_FORMAT(playlist_logs.created_at,'%d-%m-%Y %H:%i:%s') LIKE ?", ["%{$searchValue}%"]);
                    });
                }

                $orderColumn = $request->get('order')[0]['column'] ?? 0;
                $orderDir = $request->get('order')[0]['dir'] ?? 'desc';
                $columns = ['id', 'playlist_code', 'user_name', 'action', 'changes', 'created_at'];

                if (isset($columns[$orderColumn])) {
                    $orderField = $columns[$orderColumn] === 'user_name' ? 'users.name' : 'playlist_logs.' . $columns[$orderColumn];
                    if ($columns[$orderColumn] === 'playlist_code') {
                        $orderField = 'playlist_logs.playlist_code';
                    }
                    $query->orderBy($orderField, $orderDir);
                } else {
                    $query->orderBy('playlist_logs.id', 'desc');
                }

                $totalRecords = DB::table('playlist_logs')->count();
                $filteredRecords = $query->count();
                $logs = $query->skip($start)->take($length)->get();

                $data = $logs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'code' => $log->code,
                        'user_name' => $log->user_name ?? 'N/A',
                        'action' => $log->action,
                        'changes' => $this->formatChanges($log->changes, ['updated_at', 'id', 'created_at', 'playlist_code']),
                        'created_at' => date('d-m-Y H:i:s', strtotime($log->created_at)),
                        'raw_changes' => $log->changes
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
                    'error' => config('app.debug') ? $e->getMessage() : 'Error loading playlist logs',
                    'success' => false
                ], 500);
            }
        }

        return view('admin.logs.index');
    }

    // Helper method to format changes
    private function formatChanges($changes, $skipFields = ['updated_at'])
    {
        if (!$changes) {
            return 'No changes';
        }

        try {
            $changesArray = json_decode($changes, true);
            if (!$changesArray) {
                return 'No changes';
            }

            $formattedChanges = '';

            foreach ($changesArray as $key => $value) {
                // Skip specified fields
                if (in_array($key, $skipFields)) {
                    continue;
                }

                // Format the key
                $formattedKey = ucwords(str_replace('_', ' ', $key));

                // Handle different value types
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                } elseif (is_null($value)) {
                    $value = 'NULL';
                } elseif (is_bool($value)) {
                    $value = $value ? 'TRUE' : 'FALSE';
                }

                // Add the formatted change
                $formattedChanges .= "<strong>{$formattedKey}</strong>:<br>";
                $formattedChanges .= nl2br(e($value)) . "<br><br>";
            }

            return $formattedChanges ?: 'No changes';
        } catch (\Exception $e) {
            return 'Invalid changes format';
        }
    }

    public function getLogUsers(Request $request)
    {
        $user = User::where('id', Auth::id())->first();

        if ($user->role == 'admin') {
            // Get the log type from the request
            $type = $request->get('type', 'song');

            // Define the table and join column based on log type
            switch ($type) {
                case 'categories':
                    $table = 'category_logs';
                    $joinColumn = 'category_logs.user_id';
                    break;
                case 'subcategories':
                    $table = 'sub_category_logs';
                    $joinColumn = 'sub_category_logs.user_id';
                    break;
                case 'playlists':
                    $table = 'playlist_logs';
                    $joinColumn = 'playlist_logs.user_id';
                    break;
                default:
                    $table = 'song_logs';
                    $joinColumn = 'song_logs.user_id';
            }

            // Get unique users who have entries in the logs
            $users = DB::table($table)
                ->select('users.name')
                ->join('users', $joinColumn, '=', 'users.id')
                ->distinct()
                ->orderBy('users.name')
                ->pluck('users.name')
                ->toArray();

            return response()->json($users);
        }

        return response()->json([]);
    }
}

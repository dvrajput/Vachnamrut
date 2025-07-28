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
        $user = User::where('id', Auth::id())->first();

        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $type = $request->get('type', 'song');
                
                switch ($type) {
                    case 'categories':
                        return $this->getCategoryLogs();
                    case 'subcategories':
                        return $this->getSubcategoryLogs();
                    case 'playlists':
                        return $this->getPlaylistLogs();
                    default:
                        return $this->getSongLogs();
                }
            }
        }
    }

    public function getSongLogs(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $query = DB::table('song_logs')
                        ->select([
                            'song_logs.id',
                            'song_logs.song_code as code',
                            // 'song_logs.user_id',
                            'users.name as user_name',
                            'song_logs.changes',
                            'song_logs.action',
                            'song_logs.created_at'
                        ])
                        ->leftJoin('users', 'song_logs.user_id', '=', 'users.id');
                
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filterColumn('code', function($query, $keyword) {
                        $query->where('song_logs.song_code', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('user_name', function($query, $keyword) {
                        $query->where('users.name', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('action', function($query, $keyword) {
                        $query->where('song_logs.action', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('created_at', function($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(song_logs.created_at,'%d-%m-%Y %H:%i:%s') like ?", ["%{$keyword}%"]);
                    })
                    ->editColumn('changes', function($row) {
                        if ($row->changes) {
                            $changes = json_decode($row->changes, true);
                            $formattedChanges = '';
                            
                            foreach ($changes as $key => $value) {
                                // Format the key by replacing underscores with spaces and capitalizing
                                $formattedKey = ucwords(str_replace('_', ' ', $key));
                                
                                // Skip the updated_at field
                                if ($key === 'updated_at') continue;
                                
                                // Add the formatted change to the output
                                $formattedChanges .= "<strong>{$formattedKey}</strong>:<br>";
                                $formattedChanges .= nl2br(e($value)) . "<br><br>";
                            }
                            
                            return $formattedChanges;
                        }
                        return 'No changes';
                    })
                    ->editColumn('created_at', function($row) {
                        return date('d-m-Y H:i:s', strtotime($row->created_at));
                    })
                    ->editColumn('user_name', function($row) {
                        return $row->user_name ?? 'N/A'; // Handle null user names
                    })
                    ->rawColumns(['changes'])
                    ->make(true);
            }
            
            return view('admin.logs.index');
        }
        else {
            // return response()->view('errors.404', [], 404);
        }
    }

    public function getCategoryLogs(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $query = DB::table('category_logs')
                        ->select([
                            'category_logs.id',
                            'category_logs.category_code as code',
                            // 'song_logs.user_id',
                            'users.name as user_name',
                            'category_logs.changes',
                            'category_logs.action',
                            'category_logs.created_at'
                        ])
                        ->leftJoin('users', 'category_logs.user_id', '=', 'users.id');
                
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filterColumn('code', function($query, $keyword) {
                        $query->where('category_logs.category_code', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('user_name', function($query, $keyword) {
                        $query->where('users.name', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('action', function($query, $keyword) {
                        $query->where('category_logs.action', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('created_at', function($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(category_logs.created_at,'%d-%m-%Y %H:%i:%s') like ?", ["%{$keyword}%"]);
                    })
                    ->editColumn('changes', function($row) {
                        if ($row->changes) {
                            $changes = json_decode($row->changes, true);
                            $formattedChanges = '';
                            
                            foreach ($changes as $key => $value) {
                                // Format the key by replacing underscores with spaces and capitalizing
                                $formattedKey = ucwords(str_replace('_', ' ', $key));
                                
                                // Skip the updated_at field
                                if ($key === 'updated_at') continue;
                                if ($key === 'id') continue;
                                if ($key === 'created_at') continue;
                                if ($key === 'playlist_code') continue;
                                
                                // Add the formatted change to the output
                                $formattedChanges .= "<strong>{$formattedKey}</strong>:<br>";
                                $formattedChanges .= nl2br(e($value)) . "<br><br>";
                            }
                            
                            return $formattedChanges;
                        }
                        return 'No changes';
                    })
                    ->editColumn('created_at', function($row) {
                        return date('d-m-Y H:i:s', strtotime($row->created_at));
                    })
                    ->editColumn('user_name', function($row) {
                        return $row->user_name ?? 'N/A'; // Handle null user names
                    })
                    ->rawColumns(['changes'])
                    ->make(true);
            }

            return view('admin.logs.index');
        }
        else {
            // return response()->view('errors.404', [], 404);
        }
    }

    public function getSubcategoryLogs(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $query = DB::table('sub_category_logs')
                        ->select([
                            'sub_category_logs.id',
                            'sub_category_logs.sub_category_code as code',
                            // 'song_logs.user_id',
                            'users.name as user_name',
                            'sub_category_logs.changes',
                            'sub_category_logs.action',
                            'sub_category_logs.created_at'
                        ])
                        ->leftJoin('users', 'sub_category_logs.user_id', '=', 'users.id');
                
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filterColumn('code', function($query, $keyword) {
                        $query->where('sub_category_logs.sub_category_code', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('user_name', function($query, $keyword) {
                        $query->where('users.name', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('action', function($query, $keyword) {
                        $query->where('sub_category_logs.action', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('created_at', function($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(sub_category_logs.created_at,'%d-%m-%Y %H:%i:%s') like ?", ["%{$keyword}%"]);
                    })
                    ->editColumn('changes', function($row) {
                        if ($row->changes) {
                            $changes = json_decode($row->changes, true);
                            $formattedChanges = '';
                            
                            foreach ($changes as $key => $value) {
                                // Format the key by replacing underscores with spaces and capitalizing
                                $formattedKey = ucwords(str_replace('_', ' ', $key));
                                
                                // Skip the updated_at field
                                if ($key === 'updated_at') continue;
                                if ($key === 'id') continue;
                                if ($key === 'created_at') continue;
                                if ($key === 'playlist_code') continue;
                                if ($key === 'sub_category_code') continue;
                                
                                // Add the formatted change to the output
                                $formattedChanges .= "<strong>{$formattedKey}</strong>:<br>";
                                $formattedChanges .= nl2br(e($value)) . "<br><br>";
                            }
                            
                            return $formattedChanges;
                        }
                        return 'No changes';
                    })
                    ->editColumn('created_at', function($row) {
                        return date('d-m-Y H:i:s', strtotime($row->created_at));
                    })
                    ->editColumn('user_name', function($row) {
                        return $row->user_name ?? 'N/A'; // Handle null user names
                    })
                    ->rawColumns(['changes'])
                    ->make(true);
            }

            return view('admin.logs.index');
        }
        else {
            // return response()->view('errors.404', [], 404);
        }
    }

    public function getPlaylistLogs(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->role == 'admin') {
            if ($request->ajax()) {
                $query = DB::table('playlist_logs')
                        ->select([
                            'playlist_logs.id',
                            'playlist_logs.playlist_code as code',
                            // 'song_logs.user_id',
                            'users.name as user_name',
                            'playlist_logs.changes',
                            'playlist_logs.action',
                            'playlist_logs.created_at'
                        ])
                        ->leftJoin('users', 'playlist_logs.user_id', '=', 'users.id');
                
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filterColumn('code', function($query, $keyword) {
                        $query->where('playlist_logs.playlist_code', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('user_name', function($query, $keyword) {
                        $query->where('users.name', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('action', function($query, $keyword) {
                        $query->where('playlist_logs.action', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('created_at', function($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(playlist_logs.created_at,'%d-%m-%Y %H:%i:%s') like ?", ["%{$keyword}%"]);
                    })
                    ->editColumn('changes', function($row) {
                        if ($row->changes) {
                            $changes = json_decode($row->changes, true);
                            $formattedChanges = '';
                            
                            foreach ($changes as $key => $value) {
                                // Format the key by replacing underscores with spaces and capitalizing
                                $formattedKey = ucwords(str_replace('_', ' ', $key));
                                
                                // Skip the updated_at field
                                if ($key === 'updated_at') continue;
                                if ($key === 'id') continue;
                                if ($key === 'created_at') continue;
                                if ($key === 'playlist_code') continue;
                                
                                // Add the formatted change to the output
                                $formattedChanges .= "<strong>{$formattedKey}</strong>:<br>";
                                $formattedChanges .= nl2br(e($value)) . "<br><br>";
                            }
                            
                            return $formattedChanges;
                        }
                        return 'No changes';
                    })
                    ->editColumn('created_at', function($row) {
                        return date('d-m-Y H:i:s', strtotime($row->created_at));
                    })
                    ->editColumn('user_name', function($row) {
                        return $row->user_name ?? 'N/A'; // Handle null user names
                    })
                    ->rawColumns(['changes'])
                    ->make(true);
            }

            return view('admin.logs.index');
        }
        else {
            // return response()->view('errors.404', [], 404);
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

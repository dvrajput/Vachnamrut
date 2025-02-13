@extends('admin.layouts.app')
@section('title', 'Logs')
@section('style')
    <style>
        .display {
            text-align: center;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
        }
        .table {
            width: 100% !important;
        }
        .btn-group {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn-group .btn {
            min-width: 150px;
        }
        .active-log {
            background-color: #0056b3 !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ __('Logs') }}</h3>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-primary active-log" data-type="song">Song Logs</button>
            <button type="button" class="btn btn-primary" data-type="categories">Category Logs</button>
            <button type="button" class="btn btn-primary" data-type="subcategories">Subcategory Logs</button>
            <button type="button" class="btn btn-primary" data-type="playlists">Playlist Logs</button>
        </div>

        <table id="logsTable" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>{{ __('Code') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Changes') }}</th>
                    <th>{{ __('Action') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        let table;
        
        function initializeDataTable(url) {
            if (table) {
                table.destroy();
            }

            table = $('#logsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { 
                        data: 'code',
                        name: 'code'
                    },
                    { 
                        data: 'user_name',
                        name: 'user_name'
                    },
                    { 
                        data: 'changes',
                        name: 'changes',
                        width: '40%'
                    },
                    { 
                        data: 'action',
                        name: 'action'
                    },
                    { 
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                order: [[4, 'desc']],
                pageLength: 10,
                responsive: true,
                dom: 'frtip',
                searching: true,
                language: {
                    search: "Search",
                    processing: "Loading...",
                    zeroRecords: "No matching records found"
                },
                search: {
                    return: true
                }

        });
        }

         // Handle button clicks
         $('.btn-group button').on('click', function() {
            let type = $(this).data('type');
            let url = '{{ url("admin/logs") }}';
            
            // Update active button
            $('.btn-group button').removeClass('active-log');
            $(this).addClass('active-log');

            if (type !== 'song') {
                url += '/' + type;
            }
            
            // Reinitialize DataTable with new URL
            initializeDataTable(url);
        });

        // Initialize with song logs
        $(document).ready(function() {
            initializeDataTable('{{ url("admin/logs") }}');
        });
    </script>
@endsection

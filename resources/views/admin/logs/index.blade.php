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

        <div class="row mb-3 mt-3">
            <div class="col-md-3">
                <label for="userFilter">Filter by User:</label>
                <select id="userFilter" class="form-select">
                    <option value="">All Users</option>
                    <!-- Users will be loaded dynamically -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="dateSort">Sort by Date:</label>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active" id="newestFirst">Newest First</button>
                    <button type="button" class="btn btn-outline-secondary" id="oldestFirst">Oldest First</button>
                </div>
            </div>
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
        let currentLogType = 'song';
        
        function loadUsers(type) {
            // Clear existing options except the first one
            $('#userFilter').find('option:not(:first)').remove();
            
            // Load users for the current log type
            $.ajax({
                url: '{{ url("admin/logs/users") }}',
                type: 'GET',
                data: { type: type },
                dataType: 'json',
                success: function(data) {
                    // Add users to dropdown
                    $.each(data, function(key, value) {
                        $('#userFilter').append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        }
        
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
            
            // Load users for the current log type
            loadUsers(currentLogType);
        }

        // Handle button clicks for log types
        $('.btn-group button[data-type]').on('click', function() {
            currentLogType = $(this).data('type');
            let url = '{{ url("admin/logs") }}';
            
            // Update active button
            $('.btn-group button[data-type]').removeClass('active-log');
            $(this).addClass('active-log');

            if (currentLogType !== 'song') {
                url += '/' + currentLogType;
            }
            
            // Reinitialize DataTable with new URL
            initializeDataTable(url);
        });
        
        // Handle user filter
        $('#userFilter').on('change', function() {
            const selectedUser = $(this).val();
            
            if (selectedUser) {
                table.column(1).search(selectedUser).draw();
            } else {
                table.column(1).search('').draw();
            }
        });
        
        // Handle date sorting
        $('#newestFirst').on('click', function() {
            $(this).addClass('active').siblings().removeClass('active');
            table.order([4, 'desc']).draw();
        });
        
        $('#oldestFirst').on('click', function() {
            $(this).addClass('active').siblings().removeClass('active');
            table.order([4, 'asc']).draw();
        });

        // Initialize with song logs
        $(document).ready(function() {
            initializeDataTable('{{ url("admin/logs") }}');
        });
    </script>
@endsection
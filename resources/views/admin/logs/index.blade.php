@extends('admin.layouts.app')
@section('title', __('Activity Logs'))

@section('style')
    <style>
        /* Logs Container */
        .logs-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            color: white;
            box-shadow: var(--admin-shadow-sm);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Log Type Buttons */
        .log-type-container {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--admin-shadow-sm);
        }

        .log-type-title {
            color: var(--admin-text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-group-logs {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 0;
        }

        .btn-log-type {
            min-width: 150px;
            padding: 12px 20px;
            border: 2px solid var(--admin-border-color);
            background: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-log-type:hover {
            border-color: var(--admin-primary);
            color: var(--admin-primary);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(215, 134, 27, 0.3);
        }

        .btn-log-type.active-log {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
            color: white;
            box-shadow: 0 2px 8px rgba(215, 134, 27, 0.3);
        }

        /* Filters Container */
        .filters-container {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--admin-shadow-sm);
        }

        .filters-title {
            color: var(--admin-text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-row {
            display: flex;
            gap: 20px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            color: var(--admin-text-primary);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-select-custom {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid var(--admin-border-color);
            border-radius: 6px;
            background: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-select-custom:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1);
            outline: none;
        }

        .date-sort-group {
            display: flex;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid var(--admin-border-color);
        }

        .btn-date-sort {
            padding: 10px 16px;
            border: none;
            background: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-right: 1px solid var(--admin-border-color);
        }

        .btn-date-sort:last-child {
            border-right: none;
        }

        .btn-date-sort:hover {
            background: var(--admin-primary-bg);
            color: var(--admin-primary);
        }

        .btn-date-sort.active {
            background: var(--admin-primary);
            color: white;
        }

        /* Table Container */
        .table-container {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 12px;
            box-shadow: var(--admin-shadow-sm);
            overflow: hidden;
        }

        .table-header {
            background: var(--admin-bg-tertiary);
            padding: 20px 25px;
            border-bottom: 1px solid var(--admin-border-color);
        }

        .table-title {
            color: var(--admin-text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .current-log-type {
            color: var(--admin-primary);
            font-weight: 700;
            text-transform: capitalize;
        }

        /* Enhanced DataTables Styling */
        .table-responsive {
            padding: 25px;
            background: var(--admin-bg-secondary);
        }

        #logsTable {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        #logsTable thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
        }

        #logsTable tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        #logsTable tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* Log Entry Styling */
        .log-code {
            background: var(--admin-primary-bg);
            color: var(--admin-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--admin-primary);
        }

        .log-action {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .action-create {
            background: rgba(40, 167, 69, 0.2);
            color: #155724;
            border: 1px solid #28a745;
        }

        .action-update {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
            border: 1px solid #ffc107;
        }

        .action-delete {
            background: rgba(220, 53, 69, 0.2);
            color: #721c24;
            border: 1px solid #dc3545;
        }

        /* Changes Column */
        .changes-content {
            max-width: 300px;
            max-height: 150px;
            overflow-y: auto;
            text-align: left;
            font-size: 0.85rem;
            line-height: 1.4;
            scrollbar-width: thin;
            scrollbar-color: var(--admin-border-color) transparent;
        }

        .changes-content::-webkit-scrollbar {
            width: 4px;
        }

        .changes-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .changes-content::-webkit-scrollbar-thumb {
            background: var(--admin-border-color);
            border-radius: 2px;
        }

        .changes-content strong {
            color: var(--admin-primary);
        }

        .no-changes {
            color: var(--admin-text-secondary);
            font-style: italic;
        }

        /* User Column */
        .user-name {
            font-weight: 600;
            color: var(--admin-text-primary);
        }

        .user-unknown {
            color: var(--admin-text-secondary);
            font-style: italic;
        }

        /* DateTime Column */
        .log-datetime {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: var(--admin-text-secondary);
        }

        /* Loading Indicator */
        .loading-indicator {
            display: none;
            text-align: center;
            padding: 20px;
            color: var(--admin-text-secondary);
        }

        /* Processing Indicator */
        .dataTables_processing {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 200px !important;
            margin-left: -100px !important;
            margin-top: -25px !important;
            text-align: center !important;
            background: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-primary) !important;
            border-radius: 8px !important;
            padding: 15px !important;
            font-size: 16px !important;
            box-shadow: var(--admin-shadow-sm) !important;
        }

        /* DataTables Controls */
        .dataTables_wrapper {
            color: var(--admin-text-primary) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--admin-text-primary) !important;
            margin: 10px 0;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            border-radius: 6px;
            padding: 6px 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logs-container {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
            }

            .btn-group-logs {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-log-type {
                min-width: auto;
                width: 100%;
                margin-bottom: 5px;
            }

            .filter-row {
                flex-direction: column;
                gap: 15px;
            }

            .filter-group {
                min-width: auto;
            }

            .date-sort-group {
                width: 100%;
            }

            .btn-date-sort {
                flex: 1;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            #logsTable {
                font-size: 0.8rem;
            }

            #logsTable thead th,
            #logsTable tbody td {
                padding: 10px 8px;
            }

            .changes-content {
                max-width: 200px;
                max-height: 100px;
            }
        }

        @media (max-width: 480px) {
            .btn-group-logs {
                gap: 5px;
            }

            .filter-row {
                gap: 10px;
            }

            .date-sort-group {
                flex-direction: column;
            }

            .btn-date-sort {
                border-right: none;
                border-bottom: 1px solid var(--admin-border-color);
            }

            .btn-date-sort:last-child {
                border-bottom: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="logs-container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h3 class="page-title">
                    <i class="fas fa-history"></i>
                    {{ __('Activity Logs') }}
                </h3>
                <p class="page-subtitle">{{ __('Monitor system changes and user activities') }}</p>
            </div>
        </div>

        <!-- Log Type Selection -->
        <div class="log-type-container">
            <h4 class="log-type-title">
                <i class="fas fa-filter"></i>
                {{ __('Log Type') }}
            </h4>
            <div class="btn-group-logs">
                <button type="button" class="btn-log-type active-log" data-type="song">
                    <i class="fas fa-music"></i>
                    {{ __('Song Logs') }}
                </button>
                <button type="button" class="btn-log-type" data-type="categories">
                    <i class="fas fa-folder"></i>
                    {{ __('Category Logs') }}
                </button>
                <button type="button" class="btn-log-type" data-type="subcategories">
                    <i class="fas fa-folder-open"></i>
                    {{ __('Subcategory Logs') }}
                </button>
                <button type="button" class="btn-log-type" data-type="playlists">
                    <i class="fas fa-list"></i>
                    {{ __('Playlist Logs') }}
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <h4 class="filters-title">
                <i class="fas fa-sliders-h"></i>
                {{ __('Filters') }}
            </h4>
            <div class="filter-row">
                <div class="filter-group">
                    <label for="userFilter" class="filter-label">{{ __('Filter by User') }}:</label>
                    <select id="userFilter" class="form-select-custom">
                        <option value="">{{ __('All Users') }}</option>
                        <!-- Users will be loaded dynamically -->
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">{{ __('Sort by Date') }}:</label>
                    <div class="date-sort-group">
                        <button type="button" class="btn-date-sort active" id="newestFirst">
                            {{ __('Newest First') }}
                        </button>
                        <button type="button" class="btn-date-sort" id="oldestFirst">
                            {{ __('Oldest First') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-list"></i>
                    <span class="current-log-type">{{ __('Song') }}</span> {{ __('Logs') }}
                </h4>
            </div>

            <div class="table-responsive">
                <table id="logsTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Changes') }}</th>
                            <th>{{ __('Action') }}</th>
                            <th>{{ __('Date & Time') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div class="loading-indicator" id="loadingIndicator">
            <i class="fas fa-spinner fa-spin"></i>
            {{ __('Loading logs...') }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let table;
            let currentLogType = 'song';

            // Configuration
            const config = {
                logsUrl: '{{ url('admin/logs') }}',
                usersUrl: '{{ url('admin/logs/users') }}',
                csrfToken: '{{ csrf_token() }}'
            };

            // Enhanced error handling function
            function handleAjaxError(xhr, error, thrown) {
                console.error('DataTables AJAX Error:', {
                    status: xhr.status,
                    error: error,
                    thrown: thrown,
                    responseText: xhr.responseText
                });

                showNotification('Error loading logs. Please refresh the page.', 'error');
            }

            // Notification function
            function showNotification(message, type = 'info') {
                const toast = $(`
            <div class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'error' ? 'Error!' : 'Info!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('body').append(toast);
                setTimeout(() => toast.fadeOut(() => toast.remove()), 5000);
            }

            // Load users for filter dropdown
            function loadUsers(type) {
                $('#userFilter').find('option:not(:first)').remove();
                $('#loadingIndicator').show();

                $.ajax({
                    url: config.usersUrl,
                    type: 'GET',
                    data: {
                        type: type
                    },
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    timeout: 15000,
                    success: function(data) {
                        if (data && Array.isArray(data)) {
                            $.each(data, function(key, value) {
                                $('#userFilter').append(
                                    `<option value="${value}">${value}</option>`);
                            });
                        } else {
                            console.warn('Invalid users data received:', data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading users:', error);
                        showNotification('Error loading users for filter', 'warning');
                    },
                    complete: function() {
                        $('#loadingIndicator').hide();
                    }
                });
            }

            // Render action badge
            function renderActionBadge(action) {
                if (!action) return '<span class="text-muted">—</span>';

                const actionLower = action.toLowerCase();
                let className = 'log-action';

                if (actionLower.includes('create')) {
                    className += ' action-create';
                } else if (actionLower.includes('update') || actionLower.includes('edit')) {
                    className += ' action-update';
                } else if (actionLower.includes('delete')) {
                    className += ' action-delete';
                }

                return `<span class="${className}">${action}</span>`;
            }

            // Render user name
            function renderUserName(userName) {
                if (!userName || userName === 'N/A') {
                    return '<span class="user-unknown">{{ __('Unknown User') }}</span>';
                }
                return `<span class="user-name">${userName}</span>`;
            }

            // Render changes content
            function renderChanges(changes) {
                if (!changes || changes === 'No changes') {
                    return '<span class="no-changes">{{ __('No changes') }}</span>';
                }
                return `<div class="changes-content">${changes}</div>`;
            }

            // Initialize DataTable
            function initializeDataTable(url) {
                if (table) {
                    table.destroy();
                }

                table = $('#logsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        data: function(d) {
                            d._token = config.csrfToken;
                            return d;
                        },
                        error: handleAjaxError,
                        timeout: 30000
                    },
                    columns: [{
                            data: 'code',
                            name: 'code',
                            orderable: true,
                            width: '15%',
                            render: function(data, type, row) {
                                return data ? `<code class="log-code">${data}</code>` :
                                    '<span class="text-muted">—</span>';
                            }
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            orderable: true,
                            width: '12%',
                            render: function(data, type, row) {
                                return renderUserName(data);
                            }
                        },
                        {
                            data: 'changes',
                            name: 'changes',
                            orderable: false,
                            width: '40%',
                            render: function(data, type, row) {
                                return renderChanges(data);
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            width: '10%',
                            render: function(data, type, row) {
                                return renderActionBadge(data);
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                            width: '15%',
                            render: function(data, type, row) {
                                return `<span class="log-datetime">${data}</span>`;
                            }
                        }
                    ],
                    order: [
                        [4, 'desc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    responsive: true,
                    dom: 'frtip',
                    searching: true,
                    language: {
                        processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading logs...') }}',
                        search: "{{ __('Search logs') }}:",
                        lengthMenu: "{{ __('Show _MENU_ logs') }}",
                        info: "{{ __('Showing _START_ to _END_ of _TOTAL_ logs') }}",
                        infoEmpty: "{{ __('Showing 0 to 0 of 0 logs') }}",
                        infoFiltered: "({{ __('filtered from _MAX_ total logs') }})",
                        paginate: {
                            first: "{{ __('First') }}",
                            last: "{{ __('Last') }}",
                            next: "{{ __('Next') }}",
                            previous: "{{ __('Previous') }}"
                        },
                        emptyTable: "{{ __('No logs available') }}",
                        zeroRecords: "{{ __('No matching logs found') }}"
                    },
                    searchDelay: 500,
                    initComplete: function(settings, json) {
                        console.log('Logs DataTable initialized successfully');
                        loadUsers(currentLogType);
                    }
                });
            }

            // Handle log type button clicks
            $('.btn-log-type').on('click', function() {
                const newType = $(this).data('type');

                if (newType !== currentLogType) {
                    // Update current type
                    currentLogType = newType;

                    // Update active button
                    $('.btn-log-type').removeClass('active-log');
                    $(this).addClass('active-log');

                    // Update table title
                    const typeName = $(this).text().trim().replace(' Logs', '');
                    $('.current-log-type').text(typeName);

                    // Build URL
                    let url = config.logsUrl;
                    if (currentLogType !== 'song') {
                        url += '/' + currentLogType;
                    }

                    // Reset user filter
                    $('#userFilter').val('');

                    // Reinitialize DataTable
                    initializeDataTable(url);
                }
            });

            // Handle user filter changes
            $('#userFilter').on('change', function() {
                const selectedUser = $(this).val();

                if (table) {
                    if (selectedUser) {
                        table.column(1).search(selectedUser).draw();
                    } else {
                        table.column(1).search('').draw();
                    }
                }
            });

            // Handle date sorting buttons
            $('#newestFirst').on('click', function() {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active').siblings().removeClass('active');
                    if (table) {
                        table.order([4, 'desc']).draw();
                    }
                }
            });

            $('#oldestFirst').on('click', function() {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active').siblings().removeClass('active');
                    if (table) {
                        table.order([4, 'asc']).draw();
                    }
                }
            });

            // Theme change handler
            window.addEventListener('themeChanged', function(e) {
                setTimeout(function() {
                    if (table) {
                        table.draw(false);
                    }
                }, 100);
            });

            // Auto-refresh logs every 2 minutes
            setInterval(function() {
                if (document.visibilityState === 'visible' && table) {
                    table.ajax.reload(null, false);
                }
            }, 120000); // 2 minutes

            // Initialize with song logs
            initializeDataTable(config.logsUrl);
        });
    </script>
@endsection
